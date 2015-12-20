#!/usr/bin/php
<?php

/**
 * merge the customers and domains from two or more Froxlor databases into a new one.
 *
 * Prerequisites:
 *   1.) all admins must exist in the dest database with the same loginname,
 *       we rewrite admin ids, but do not create/transfer admins
 *
 *   2.) domains, ftps, emailaccounts etc. must be unique, e.g. we cannot merge
 *       two databases both containing the same domains etc.
 *
 *   3.) the databases must be of the same version, e.g. if you want to merge an older
 *       installation, upgrade first, then merge.
 *
 *   4.) the absolute paths must be the same (e.g. /var/customers/ everywhere) - there is no
 *       path rewriting (yet)
 *
 * Usage:
 *   1.) upgrade all databases to be merged to the latest version
 *
 *   2.) import all databases to the local db server
 *
 *   3.) copy the first database to the dest db
 *
 *   4.) adapt global settings, especially IPs
 *
 *   5.) run this script for all other dbs, they get merged into dest db
 *
 *  Additional Notes:
 *
 *   1.) the merging may change the uid/gid of the user, since these must be unique. Make sure
 *       to chown the customer dirs properly after merging.
 *
 *   2.) if a customer exists in different databases, we try to merge accounts, databases and
 *       domains. However, for accounts (e.g. ftp, mail, ...) which exists in both databases,
 *       no settings (like password, shell, ...) will be merged (instead, the settings will be
 *       taken from the first database).
 *
 *   3.) IPs and Ports are merged using IP and Port as keys; depending on your setup you may
 *       want to reassign them later.
 */


const DEFAULT_ADMIN_ID = '1';

class FroxMerger
{

    function __construct($src, $dest)
    {
        $this->src = $src;
        $this->src->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->src->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

        $this->dest = $dest;
        $this->dest->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->dest->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

        // we need sorting function for domains (stored procedure)
        // $this->src->exec(_storedproc);

        $this->admin_map = array();
        $this->customer_map = array();
        $this->customer_guids = array();
        $this->ipport_map = array();
        $this->domain_map = array();
        $this->account_map = array();
    }

    function merge()
    {
        // merge customers
        $this->merge_customers();

        // merge tickets
        $this->merge_tickets();

        // merge databases
        $this->merge_databases();

        // merge ftp_groups, ftp_users
        // TODO: ftp_quotalimits are not customer dependent?
        $this->merge_ftps();

        // merge htaccess, htpasswd
        $this->merge_htaccess();

        // merge ips and ports
        $this->merge_ips_ports();

        // merge domains (w/ IPs, redirects, SSL settings)
        $this->merge_domains();

        // merge mail_users, mail_virtual
        $this->merge_mail();

        // merge panel_syslog
        $this->merge_syslog();

        // merge diskspace & traffic
        // -> skip, takes VERY long
        // $this->merge_traffic();
    }

    function merge_customers()
    {
        print "*** merging customers ***\n";

        $stmt = $this->src->query("SELECT * FROM panel_customers");

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $customer) {
            $old_customer_id = $customer['customerid'];
            // lookup customer
            $new_customer_id = $this->lookup_entity_by_name('panel_customers',
                'loginname',
                $old_customer_id,
                false,
                'customerid');
            if ($new_customer_id === false) {
                $guid = $this->get_next_available_guid();
                $replacements = array(
                    'adminid' => $this->get_dest_admin_id($customer['adminid']),
                    'guid' => $guid
                );
                $new_customer_id = $this->merge_entity_by_name('panel_customers',
                    'loginname',
                    $old_customer_id,
                    $replacements,
                    'customerid');
            } else {
                $guid = $this->qc($this->dest,
                    'SELECT guid FROM panel_customers WHERE customerid=?',
                    array($new_customer_id));
            }
            print "\t" . $customer['loginname'] . '/' . $guid . ' (' . $old_customer_id . ' => ' . $new_customer_id . ")\n";
            $this->customer_map[$old_customer_id] = $new_customer_id;
            $this->customer_guids[$old_customer_id] = $guid;
        }
    }

    /** merge tickets */
    function merge_tickets()
    {
        print "*** merging tickets ***\n";

        $stmt = $this->q($this->src, "SELECT * FROM panel_tickets", array());

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $ticket) {
            unset($ticket['id']);
            $ticket['adminid'] = $this->get_dest_admin_id($ticket['adminid']);
            if ($ticket['customerid']) {
                $ticket['customerid'] = $this->customer_map[$ticket['customerid']];
            }
            // handle category (may be NULL or 0)
            if ($ticket['category'])
                $ticket['category'] = $this->merge_entity_by_name('panel_ticket_categories',
                    'name',
                    $ticket['category']);
            $this->ins($this->dest, 'panel_tickets', $ticket);
            print "\tmerged \"" . $ticket['subject'] . "\"\n";
        }
    }

    function merge_databases()
    {
        print "*** merging databases ***\n";

        $stmt = $this->q($this->src, "SELECT * FROM panel_databases", array());
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            unset($row['id']);
            $row['customerid'] = $this->customer_map[$row['customerid']];
            if ($row['customerid']) {
                $this->ins($this->dest, 'panel_databases', $row);
                print "\tmerged " . $row['databasename'] . "\n";
            } else {
                print "\tskipped " . $row['databasename'] . "\n";
            }
        }
    }

    function merge_ftps()
    {

        print "*** merging ftpgroups ***\n";
        $stmt = $this->q($this->src, "SELECT * FROM ftp_groups", array());
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            // if we merge the same customers from different dbs,
            // the ftp group may already be there
            $dest = $this->qs($this->dest,
                "SELECT * FROM ftp_groups WHERE groupname=?",
                array($row['groupname']));
            if ($dest !== false) {
                // group already exists, merge it
                $srcmembers = explode(',', $row['members']);
                $destmembers = explode(',', $dest['members']);
                $merged = array_unique(array_merge($srcmembers, $destmembers));
                $dest['members'] = implode(',', $merged);
                $this->upd($this->dest, 'ftp_groups', $dest);
                print "\tupdated " . $row['groupname'] . " (already existing in dest)\n";
            } else {
                // create new group
                unset($row['id']);
                $old_customer_id = $row['customerid'];
                if (array_key_exists($old_customer_id, $this->customer_map)) {
                    $row['customerid'] = $this->customer_map[$old_customer_id];
                    $row['gid'] = $this->customer_guids[$old_customer_id];
                    $this->ins($this->dest, 'ftp_groups', $row);
                    print "\tadded " . $row['groupname'] . "\n";
                } else {
                    print "\tskipping " . $row['groupname'] . " (pointing to nonexistent customer)\n";
                }
            }
        }

        print "*** merging ftpusers ***\n";
        $stmt = $this->q($this->src, "SELECT * FROM ftp_users", array());
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $dest = $this->qs($this->dest,
                "SELECT * FROM ftp_users WHERE username=?",
                array($row['username']));
            if ($dest !== false) {
                print "\tskipping " . $row['username'] . " (already existing in dest)\n";
            } else {
                unset($row['id']);
                $old_customer_id = $row['customerid'];
                $row['customerid'] = $this->customer_map[$old_customer_id];
                if ($row['customerid']) {
                    $row['uid'] = $this->customer_guids[$old_customer_id];
                    $row['gid'] = $this->customer_guids[$old_customer_id];
                    $this->ins($this->dest, 'ftp_users', $row);
                    print "\tcreated " . $row['username'] . "\n";
                } else {
                    print "\tskipping " . $row['username'] . " (pointing to nonexistent customer)\n";
                }
            }
        }

        print "*** merging quotatallies ***\n";
        $stmt = $this->q($this->src, "SELECT * FROM ftp_quotatallies", array());
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $dest = $this->qs($this->dest,
                'SELECT * FROM ftp_quotatallies WHERE name=?',
                array($row['name']));
            if ($dest === false) {
                $this->ins($this->dest, 'ftp_quotatallies', $row);
                print "\tmerged " . $row['name'] . "\n";
            } else {
                // skip, next traffic calculation will correct values
            }
        }
    }

    function merge_htaccess()
    {
        print "*** merging htaccess ***\n";
        $stmt = $this->q($this->src, "SELECT * FROM panel_htaccess", array());
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            unset($row['id']);
            $row['customerid'] = $this->customer_map[$row['customerid']];
            if ($row['customerid']) {
                $this->ins($this->dest, 'panel_htaccess', $row);
                print "\tmerged " . $row['path'] . "\n";
            } else {
                print "\tskipping " . $row['path'] . "\n";
            }
        }

        print "*** merging htpasswd ***\n";
        $stmt = $this->q($this->src, "SELECT * FROM panel_htpasswds", array());
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            unset($row['id']);
            $row['customerid'] = $this->customer_map[$row['customerid']];
            if ($row['customerid']) {
                $this->ins($this->dest, 'panel_htpasswds', $row);
                print "\tmerged " . $row['path'] . "\n";
            } else {
                print "\tskipping " . $row['path'] . "\n";
            }
        }
    }

    function merge_ips_ports()
    {
        print "*** merging ips and ports ***\n";
        $stmt = $this->q($this->src, "SELECT * FROM panel_ipsandports");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $destid = $this->qc($this->dest,
                "SELECT id FROM panel_ipsandports WHERE ip=? and port=?",
                array($row['ip'], $row['port']));
            if ($destid === false) {
                $oldid = $row['id'];
                unset($row['id']);
                $this->ipport_map[$oldid] = $this->ins($this->dest, 'panel_ipsandports', $row);
            }
        }
    }

    function merge_domains()
    {
        print "*** merging domains ***\n";
        // build ipportmap
        $ipportmap = array();
        $stmt = $this->q($this->src, "SELECT * FROM panel_ipsandports");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $destid = $this->qc($this->dest,
                "SELECT id FROM panel_ipsandports WHERE ip=? and port=?",
                array($row['ip'], $row['port']));
            if ($destid !== false) {
                $ipportmap[$row['id']] = $destid;
            } else {
                $ipportmap[$row['id']] = ($row['ssl'] == '1') ? DEFAULT_IPPORT_HTTPS_ID : DEFAULT_IPPORT_HTTP_ID;
            }
        }
        $stmt = $this->q($this->src, "SELECT * FROM panel_domains ORDER BY id, parentdomainid, ismainbutsubto, aliasdomain");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $old_domain_id = $row['id'];
            unset($row['id']);
            if ($row['parentdomainid']) {
                $row['parentdomainid'] = $this->domain_map[$row['parentdomainid']];
            }
            if ($row['ismainbutsubto']) {
                $row['ismainbutsubto'] = $this->domain_map[$row['ismainbutsubto']];
            }
            if ($row['aliasdomain']) {
                $row['aliasdomain'] = $this->domain_map[$row['aliasdomain']];
            }
            // for subdomain created by customer, adminid is null
            if ($row['adminid'])
                $row['adminid'] = $this->get_dest_admin_id($row['adminid']);
            $row['customerid'] = $this->customer_map[$row['customerid']];

            // TODO: map phpsettingid (but we don't have that - it's always "1" here)

            $new_domain_id = $this->ins($this->dest, 'panel_domains', $row);
            $this->domain_map[$old_domain_id] = $new_domain_id;

            print "\tmerged " . $row['domain'] . "\n";
        }

        print "*** merging domaintoip ***\n\t";
        $stmt = $this->q($this->src, "SELECT * FROM panel_domaintoip");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $row['id_domain'] = $this->domain_map[$row['id_domain']];
            $row['id_ipandports'] = $this->ipport_map[$row['id_ipandports']];
            $this->ins($this->dest, 'panel_domaintoip', $row);
            print ".";
        }
        print "\n";

        print "*** merging domain_redirect_codes ***\n\t";
        $stmt = $this->q($this->src, "SELECT * FROM domain_redirect_codes");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $row['did'] = $this->domain_map[$row['did']];
            $this->ins($this->dest, 'domain_redirect_codes', $row);
            print ".";
        }
        print "\n";

        print "*** merging domain_ssl_settings ***\n\t";
        $stmt = $this->q($this->src, "SELECT * FROM domain_ssl_settings");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $row['domainid'] = $this->domain_map[$row['id_domain']];
            $this->ins($this->dest, 'domain_ssl_settings', $row);
            print ".";
        }
        print "\n";

    }

    function merge_mail()
    {

        print "*** merging mail_users ***\n";

        $stmt = $this->q($this->src, "SELECT * FROM mail_users");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $old_account_id = $row['id'];
            unset($row['id']);
            $row['domainid'] = $this->domain_map[$row['domainid']];
            $row['customerid'] = $this->customer_map[$row['customerid']];
            // we don't rewrite uid/gid as that's always 2000 in every
            // system we have
            $this->account_map[$old_account_id] = $this->ins($this->dest,
                'mail_users',
                $row);
            print "\tmerged " . $row['email'] . "\n";
        }

        print "*** merging mail_virtual ***\n";

        $stmt = $this->q($this->src, "SELECT * FROM mail_virtual");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $old_account_id = $row['id'];
            unset($row['id']);
            $row['domainid'] = $this->domain_map[$row['domainid']];
            $row['customerid'] = $this->customer_map[$row['customerid']];
            if ($row['popaccountid'])
                $row['popaccountid'] = $this->account_map[$row['popaccountid']];
            $this->ins($this->dest, 'mail_virtual', $row);
            print "\tmerged " . $row['email'] . "\n";
        }

    }

    function merge_syslog()
    {
        print "*** merging syslog ***\n\t";

        $stmt = $this->q($this->src, "SELECT * FROM panel_syslog");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            // TODO: eventually add some identifier to the text to indicate the source
            unset($row['logid']);
            $this->ins($this->dest, 'panel_syslog', $row);
            print ".";
        }
        print "\n";

    }

    function merge_traffic()
    {

        print "*** merging customer traffic ***\n";
        $stmt = $this->q($this->src, "SELECT * FROM panel_traffic", array());
        $count = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            unset($row['id']);
            $row['customerid'] = $this->customer_map[$row['customerid']];
            if ($row['customerid']) {
                $this->ins($this->dest, 'panel_traffic', $row);
            }
            $count++;
            if ($count % 1000 == 0) {
                print "\tmerged $count rows\n";
                flush();
            }
        }

        print "*** merging admin traffic ***\n";
        $count = 0;
        $stmt = $this->q($this->src, "SELECT * FROM panel_traffic_admins", array());
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            unset($row['id']);
            $row['adminid'] = $this->get_dest_admin_id($row['adminid']);
            if ($row['adminid']) {
                $this->ins($this->dest, 'panel_traffic_admins', $row);
            }
            $count++;
            if ($count % 1000 == 0) {
                print "\tmerged $count rows\n";
                flush();
            }
        }

        print "*** merging customer diskspace ***\n";
        $stmt = $this->q($this->src, "SELECT * FROM panel_diskspace", array());
        $count = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            unset($row['id']);
            $row['customerid'] = $this->customer_map[$row['customerid']];
            if ($row['customerid']) {
                $this->ins($this->dest, 'panel_diskspace', $row);
            }
            $count++;
            if ($count % 1000 == 0) {
                print "\tmerged $count rows\n";
                flush();
            }
        }

        print "*** merging admin diskspace ***\n";
        $count = 0;
        $stmt = $this->q($this->src, "SELECT * FROM panel_diskspace_admins", array());
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            unset($row['id']);
            $row['adminid'] = $this->get_dest_admin_id($row['adminid']);
            if ($row['adminid']) {
                $this->ins($this->dest, 'panel_diskspace_admins', $row);
            }
            $count++;
            if ($count % 1000 == 0) {
                print "\tmerged $count rows\n";
                flush();
            }
        }
    }


    /**
     * get the id for the new admin by searching over the name. If there's no admin with
     *  the given loginname in $dest, use DEFAULT_ADMIN_ID instead.
     *
     * @param $adminid  adminid in src database
     * @return int adminid in dest database
     */
    protected function get_dest_admin_id($adminid)
    {
        if (array_key_exists($adminid, $this->admin_map)) {
            return $this->admin_map[$adminid];
        } else {
            $result = $this->lookup_entity_by_name('panel_admins',
                'loginname',
                $adminid,
                DEFAULT_ADMIN_ID,
                'adminid');
            $this->admin_map[$adminid] = $result;
            return $result;
        }
    }

    protected function get_next_available_guid()
    {
        $guid = (int)$this->qc($this->dest, 'SELECT MAX(guid) FROM panel_customers');
        return $guid + 1;
    }

    /**
     * look up an entity in the dest system by a common, unique key such as loginname
     *
     * @param $table
     * @param $name_col
     * @param $src_id
     * @param bool|false $default
     * @param string $id_col
     * @return id in the new system, or $default if not found
     */
    protected function lookup_entity_by_name($table, $name_col, $src_id, $default = false, $id_col = 'id')
    {
        // retrieve id in old system
        $name = $this->qc($this->src,
            'SELECT `' . $name_col . '` FROM `' . $table . '` WHERE `' . $id_col . '`=?',
            array($src_id));

        // look it up in new system
        $destid = $this->qc($this->dest,
            'SELECT `' . $id_col . '` FROM `' . $table . '` WHERE `' . $name_col . '`=?',
            array($name));

        if ($destid === false) {
            return $default;
        } else {
            return $destid;
        }
    }

    /**
     * merge an entity by a common, unique key, such as loginname.
     *
     * This function looks up the entity in the source db, and either
     * returns the id of the matching column in the dest db, or creates
     * the entity in the dest db and returns the id of the newly created
     * row.
     *
     * @param string $table table name
     * @param string $name_col name of column with key field
     * @param mixed $src_id id in source table
     * @param array $replacements (optional) replacement values if entity is inserted
     * @param string $id_col (optional) name of primary key column
     * @return int id of merged entity
     */
    protected function merge_entity_by_name($table, $name_col, $src_id, $replacements = array(), $id_col = 'id')
    {
        // retrieve item in old system
        $src = $this->qs($this->src,
            'SELECT * FROM `' . $table . '` WHERE `' . $id_col . '`=?',
            array($src_id));
        $name = $src[$name_col];
        // look it up in new system
        $destid = $this->qc($this->dest,
            'SELECT `' . $id_col . '` FROM `' . $table . '` WHERE `' . $name_col . '`=?',
            array($name));
        if ($destid === false) {
            // not found, insert it
            unset($src[$id_col]);
            foreach ($replacements as $col => $val) {
                $src[$col] = $val;
            }
            return $this->ins($this->dest, $table, $src);
        } else {
            // found, return dest id
            return $destid;
        }
    }

    /**
     * helper: execute a query using prepared statement, and return the result
     * @param $connection
     * @param $query
     * @param $params
     * @return mixed
     */
    protected function q($connection, $query, $params = array())
    {
        $stmt = $connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * helper: fetch a single row
     * @param $connection
     * @param $query
     * @param $params
     * @return mixed row, or false if there are no rows
     */
    protected function qs($connection, $query, $params = array())
    {
        $result = false;
        $stmt = $this->q($connection, $query, $params);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $result = $data;
        }
        return $result;
    }

    /**
     * helper: execute a query trough prepared statement, returning a single column
     *
     * @param $connection
     * @param $query
     * @param $params
     * @return mixed
     */
    protected function qc($connection, $query, $params = array())
    {
        $stmt = $this->q($connection, $query, $params);
        $result = $stmt->fetchColumn();
        $stmt->closeCursor();
        unset($stmt);
        return $result;
    }

    /**
     * helper: insert data from associative array through PDO
     * @param $connection   PDO     db connection
     * @param $query    string  query
     * @param $data   array   data to insert (assoc. array)
     * @return  int    id of inserted element
     */
    protected function ins($connection, $table, $data)
    {
        $fields = array_keys($data);
        $values = array_values($data);
        $fieldlist = implode('`,`', $fields);
        $qs = str_repeat("?,", count($fields) - 1);

        $sql = "INSERT INTO `" . $table . "` (`" . $fieldlist . "`) VALUES (${qs}?)";

        $q = $connection->prepare($sql);
        $q->execute($values);
        return $connection->lastInsertId();
    }

    /**
     * helper:
     * @param $connection
     * @param $table
     * @param $data
     * @param string $keycol
     * @return mixed
     */
    protected function upd($connection, $table, $data, $keycol = 'id')
    {
        $key = $data[$keycol];
        unset($data[$keycol]);
        $fields = array_keys($data);
        $fieldlist = implode('`=?,`', $fields);
        $values = array_values($data);
        $values[] = $key;
        $sql = "UPDATE `" . $table . "` SET `" . $fieldlist . "`=? WHERE `" . $keycol . "`=?";
        $q = $connection->prepare($sql);
        $q->execute($values);
        return $key;
    }

}

function usage()
{
    print "\nphp froxmerge.php -u dbuser -p password [-h host] SRC_DATABASE DEST_DATABASE\n\n";
    print "merges SRC_DATABASE into DEST_DATABASE\n";
}

function get_db($dbname, $opts)
{
    $dsn = "mysql:charset=utf8;dbname=$dbname";
    if (array_key_exists('h', $opts)) {
        $hostname = $opts['h'];
        $dsn .= ";hostname=$hostname";
    }
    return new PDO($dsn, $opts['u'], $opts['p']);
}

/* parse arguments */

$shortopts = "";
$shortopts .= "u:"; // database user
$shortopts .= "p:"; // database password
$shortopts .= "h:"; // database host (optional)

$opts = getopt($shortopts);
$args = array_slice($argv, count($opts) * 2 + 1);

if (count($args) < 2 || !array_key_exists('u', $opts) || !array_key_exists('p', $opts)) {
    usage();
    exit();
}

/* build connections */
$src = get_db($args[0], $opts);
$dest = get_db($args[1], $opts);

/* run merger */
$merger = new FroxMerger($src, $dest);
$merger->merge();
