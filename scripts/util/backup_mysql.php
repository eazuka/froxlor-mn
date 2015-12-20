#!/usr/bin/php
<?php
/**
 * utility script which can do daily backups of mysql database. Reads all hosts from userdata.inc.php
 * and backups them to BACKUP_LOCATION.
 */

include_once dirname(dirname(__FILE__)) . '/../lib/userdata.inc.php';

function get_db_list($host) {
	$hostname = $host['host'];
	$user = $host['user'];
	$password = $host['password'];
	$cmd = "mysql --host=${hostname} --user=${user} --password=${password} -B --skip-column-names -e 'show databases;'";
	$db_list = explode("\n", shell_exec($cmd));
	return array_diff($db_list, ['information_schema', 'performance_schema', '']);
}

function dump_db($host, $dbname, $filename) {
	$hostname = $host['host'];
	$user = $host['user'];
	$password = $host['password'];
	$cmd = "mysqldump --events --routines -h ${hostname} --user=${user} --password=${password} -R ${dbname} | gzip > ${filename}";
	shell_exec($cmd);
}


$BACKUP_LOCATION = '/var/backups/mysql';
$BACKUP_LOCATION = '/tmp/mysqlbackup/';
$today = date('Y-m-d');

$path = "${BACKUP_LOCATION}/${today}";

shell_exec("mkdir -p ${path}");

/** make new backup **/
foreach($sql_root as $host) {
	foreach(get_db_list($host) as $dbname) {
		dump_db($host, $dbname, "${path}/${dbname}.sql.gz");
	}
}

/** delete old backups, except yesterday, first day of month, first day of last month **/
$dt = getdate();
$yesterday = date('Y-m-d', strtotime('-1 day'));
$this_month = date('Y-m-d', strtotime('first day of'));
$last_month = date('Y-m-d', strtotime('first day of last month'));

foreach(scandir($BACKUP_LOCATION) as $backup) {
	if(preg_match('/^(\d{4})-(\d{2})-(\d{2})$/',$backup, $matches)) {
		if (FALSE===array_search($matches[0], [$today, $yesterday, $this_month, $last_month])) {
			//print "deleting: ${matches[0]}\n";
			shell_exec("rm -rf ${BACKUP_LOCATION}/${matches[0]}");
		}
	}
}
