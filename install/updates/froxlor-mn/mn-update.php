<?php
/**
 * database updates for froxlor-mn
 **/

/**
 * install multinode (initial version)
 */
if (!MN_getVersion()) {
	showUpdateStep("Updating to multinode 0.0.1.0", false);

	Database::query("ALTER TABLE `cronjobs_run` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `domain_ssl_settings` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `domain_redirect_codes` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `ftp_groups` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `ftp_quotalimits` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `ftp_quotatallies` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `ftp_users` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `mail_users` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `mail_virtual` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_activation` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_admins` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_customers` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_databases` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_diskspace` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_diskspace_admins` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_domains` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_domaintoip` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_htaccess` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_htpasswds` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_ipsandports` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_languages` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_phpconfigs` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_sessions` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_settings` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_syslog` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_tasks` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_templates` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_ticket_categories` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_tickets` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_traffic` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `panel_traffic_admins` ENGINE=InnoDB;");
	Database::query("ALTER TABLE `redirect_codes` ENGINE=InnoDB;");

	Database::query("ALTER TABLE `ftp_groups`
    	MODIFY COLUMN `customerid` INT(11) UNSIGNED NULL");
	Database::query("UPDATE `ftp_groups` set customerid=NULL where customerid='0'");
	Database::query("ALTER TABLE `ftp_groups`
		DROP KEY `customerid`,
    	ADD FOREIGN KEY `fk_customer` (`customerid`)
        	REFERENCES panel_customers(customerid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `ftp_users`
    	MODIFY COLUMN `customerid` INT(11) UNSIGNED NOT NULL,
    	DROP KEY `customerid`,
    	ADD FOREIGN KEY `fk_customer` (customerid)
        	REFERENCES panel_customers(customerid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `mail_users`
    	MODIFY COLUMN `customerid` INT(11) UNSIGNED NOT NULL,
    	MODIFY COLUMN `domainid` INT(11) UNSIGNED NULL,
    	ADD FOREIGN KEY `fk_customer` (customerid)
        	REFERENCES panel_customers(customerid)
        	ON UPDATE CASCADE ON DELETE CASCADE,
    	ADD FOREIGN KEY `fk_domain` (domainid)
        	REFERENCES panel_domains(id)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `mail_virtual`
    	MODIFY COLUMN `customerid` INT(11) UNSIGNED NOT NULL,
    	MODIFY COLUMN `domainid` INT(11) UNSIGNED NOT NULL,
    	MODIFY COLUMN `popaccountid` INT(11)");

	Database::query("UPDATE `mail_virtual`
		SET popaccountid=NULL WHERE popaccountid='0' OR popaccountid='';");

	Database::query("ALTER TABLE `mail_virtual`
    	ADD FOREIGN KEY `fk_customer` (customerid)
	        REFERENCES panel_customers(customerid)
    	    ON UPDATE CASCADE ON DELETE CASCADE,
    	ADD FOREIGN KEY `fk_domain` (domainid)
        	REFERENCES panel_domains(id)
        	ON UPDATE CASCADE ON DELETE CASCADE,
    	ADD FOREIGN KEY `fk_account` (popaccountid)
        	REFERENCES mail_users(id)
        	ON UPDATE CASCADE ON DELETE SET NULL;");

	Database::query("ALTER TABLE `panel_customers`
    	ADD FOREIGN KEY `fk_admin` (adminid)
        	REFERENCES panel_admins(adminid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `panel_databases`
    	MODIFY COLUMN `customerid` INT(11) UNSIGNED NOT NULL,
    	ADD FOREIGN KEY `fk_customer` (customerid)
        	REFERENCES panel_customers(customerid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `panel_domains`
    	MODIFY COLUMN `parentdomainid` INT(11) UNSIGNED DEFAULT NULL,
    	MODIFY COLUMN `aliasdomain` INT(11) UNSIGNED DEFAULT NULL,
    	MODIFY COLUMN `ismainbutsubto` INT(11) UNSIGNED DEFAULT NULL,
    	MODIFY COLUMN `adminid` INT(11) UNSIGNED DEFAULT NULL");

	Database::query("UPDATE panel_domains SET parentdomainid = NULL WHERE parentdomainid='0';");
	Database::query("UPDATE panel_domains SET aliasdomain = NULL WHERE aliasdomain='0';");
	Database::query("UPDATE panel_domains SET ismainbutsubto = NULL WHERE ismainbutsubto='0';");
	Database::query("UPDATE panel_domains SET adminid = NULL WHERE adminid='0';");

	Database::query("ALTER TABLE `panel_domains`
    	DROP KEY `customerid`,
    	DROP KEY `parentdomain`,
    	ADD FOREIGN KEY `fk_admin` (adminid)
        	REFERENCES panel_admins(adminid)
        	ON UPDATE CASCADE ON DELETE CASCADE,
    	ADD FOREIGN KEY `fk_customer` (customerid)
        	REFERENCES panel_customers(customerid)
        	ON UPDATE CASCADE ON DELETE CASCADE,
    	ADD FOREIGN KEY `fk_mainsub` (ismainbutsubto)
        	REFERENCES panel_domains(id)
        	ON UPDATE CASCADE ON DELETE CASCADE,
    	ADD FOREIGN KEY `fk_parent` (parentdomainid)
        	REFERENCES panel_domains(id)
        	ON UPDATE CASCADE ON DELETE CASCADE,
    	ADD FOREIGN KEY `fk_alias` (aliasdomain)
	        REFERENCES panel_domains(id)
    	    ON UPDATE CASCADE ON DELETE SET NULL,
    	ADD FOREIGN KEY `fk_phpsetting` (phpsettingid)
        	REFERENCES panel_phpconfigs(id)
        	ON UPDATE CASCADE;");

	Database::query("ALTER TABLE `panel_htaccess`
    	ADD FOREIGN KEY `fk_customer` (customerid)
	        REFERENCES panel_customers(customerid)
    	    ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `panel_htpasswds`
    	DROP KEY `customerid`,
    	ADD FOREIGN KEY `fk_customerid` (customerid)
        	REFERENCES panel_customers(customerid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	/* NOTE: panel_sessions.userid points either to panel_admins or
	   panel_customers, so we can't use foreign key */

	Database::query("ALTER TABLE `panel_templates`
    	MODIFY COLUMN `adminid` INT(11) UNSIGNED NOT NULL,
    	DROP KEY `adminid`,
    	ADD FOREIGN KEY `fk_admin` (adminid)
        	REFERENCES panel_admins(adminid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	// it seems there are occasions where traffic info
	// for deleted customers is still in the database.
	// remove that, just in case
	Database::query("DELETE FROM `panel_traffic` WHERE customerid NOT IN (SELECT customerid FROM `panel_customers`)");

	Database::query("ALTER TABLE `panel_traffic`
    	DROP KEY `customerid`,
    	ADD FOREIGN KEY `fk_customer` (customerid)
        	REFERENCES panel_customers(customerid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `panel_traffic_admins`
    	DROP KEY `adminid`,
    		ADD FOREIGN KEY `fk_admin` (adminid)
        	REFERENCES panel_admins(adminid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	// it seems there are occasions where diskspace info
	// for deleted customers is still in the database.
	// remove that, just in case
	Database::query("DELETE FROM `panel_diskspace` WHERE customerid NOT IN (SELECT customerid FROM `panel_customers`)");

	Database::query("ALTER TABLE `panel_diskspace`
    	DROP KEY `customerid`,
    	ADD FOREIGN KEY `fk_customer` (customerid)
        	REFERENCES panel_customers(customerid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `panel_diskspace_admins`
    	DROP KEY `adminid`,
    	ADD FOREIGN KEY `fk_admin` (adminid)
        	REFERENCES panel_admins(adminid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `panel_tickets`
    	MODIFY COLUMN `adminid` INT(11) UNSIGNED NOT NULL,
    	MODIFY COLUMN `customerid` INT(11) UNSIGNED DEFAULT NULL");
	Database::query("UPDATE `panel_tickets` set customerid=NULL where customerid='0'");
	Database::query("ALTER TABLE `panel_tickets`
		DROP KEY `customerid`,
    	  ADD FOREIGN KEY `fk_admin` (adminid)
	        REFERENCES panel_admins(adminid)
    	    ON UPDATE CASCADE ON DELETE CASCADE,
    	ADD FOREIGN KEY `fk_customer` (customerid)
        	REFERENCES panel_customers(customerid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `panel_ticket_categories`
    	MODIFY COLUMN `adminid` INT(11) UNSIGNED DEFAULT NULL,
    	ADD FOREIGN KEY `fk_admin` (adminid)
        	REFERENCES panel_admins(adminid)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	// it seems there can be redirect codes for deleted
	// domains. Delete those, too
	Database::query("DELETE from `domain_redirect_codes` where did not in (select id from `panel_domains`)");

	Database::query("ALTER TABLE `domain_redirect_codes`
    	ADD PRIMARY KEY `pk` (`rid`,`did`),
    	ADD FOREIGN KEY `fk_redirect` (`rid`)
	        REFERENCES redirect_codes(id)
    	    ON UPDATE CASCADE ON DELETE CASCADE,
    	ADD FOREIGN KEY `fk_domain` (did)
        	REFERENCES panel_domains(id)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `domain_ssl_settings`
    	MODIFY COLUMN `domainid` INT(11) UNSIGNED NOT NULL,
    	ADD FOREIGN KEY `fk_domain` (domainid)
        	REFERENCES panel_domains(id)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `panel_domaintoip`
    	ADD FOREIGN KEY `fk_domain` (id_domain)
        	REFERENCES panel_domains(id)
        	ON UPDATE CASCADE ON DELETE CASCADE,
    	ADD FOREIGN KEY `fk_ipandport` (id_ipandports)
        	REFERENCES panel_ipsandports(id)
        	ON UPDATE CASCADE ON DELETE CASCADE;");

	Database::query("ALTER TABLE `ftp_quotalimits`
		ADD PRIMARY KEY `pk` (`name`, `quota_type`);");

	Database::query("ALTER TABLE `ftp_quotatallies`
		ADD PRIMARY KEY `pk` (`name`, `quota_type`);");

	// add setting for webserver group
	Settings::AddNew('system.customerdir_group_webserver', '0');

	// add multinode version
	Settings::AddNew('multinode.version', '0.0.1.0');
}

if (MN_getVersion()==array(0,0,1,0)) {
	showUpdateStep("Updating to multinode 0.0.2.0", false);
	Database::query("CREATE TABLE `panel_nodes` (
  		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  		`name` varchar(64) NOT NULL,
  		`image_name` varchar(128) NOT NULL,
  		`image_tag` varchar(128) DEFAULT 'latest' NOT NULL,
  		PRIMARY KEY (`id`)
		) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;");
	Database::query("CREATE TABLE `panel_nodetoip` (
  		`id_node` int(11) unsigned NOT NULL,
  		`id_ipandport` int(11) unsigned NOT NULL,
  		PRIMARY KEY (`id_node`,`id_ipandport`),
  		FOREIGN KEY `fk_node` (id_node)
  			REFERENCES panel_nodes(id)
    		ON UPDATE CASCADE ON DELETE CASCADE,
  		FOREIGN KEY `fk_ipandport` (id_ipandport)
  			REFERENCES panel_ipsandports(id)
    		ON UPDATE CASCADE ON DELETE CASCADE
		) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;");

	Settings::Set('multinode.version', '0.0.2.0');
}
