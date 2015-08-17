<?php

/**
 * This is just an example about how to use the ORM to display a list of customers,
 * domains and IPs. It is for development only and should never be put into any release.
 */

define('AREA', 'admin');
require './lib/init.php';
require './lib/doctrine_init.php';

$cls = new Froxlor\DB\Customer();

$customers = $em->getRepository('Froxlor\DB\Customer')->findAll();

$exportdata = array();

foreach($customers as $customer) {
	print '<h3><tt>' . $customer->loginname. '</tt></h3>';
	foreach($customer->tickets as $ticket) {
		$exportdata['tickets'][] = $ticket->toArray($em);
	}
	/* for each customer we need:

	 - tickets
	 - diskspace
	 - traffic
	 - databases
	 - ftp_groups
	 - ftp_users
	 - htaccess
	 - htpasswd
	 - mail_users
	 - mail_virtual

    */
	foreach($customer->domains as $domain) {
		print "<pre>";
		print_r($domain->toArray($em, true));
		print "</pre>";
	}

	print '<hr>';

	/*
	foreach ($customer->domains()->find_many() as $domain) {
		print $domain->domain . ' (' .$domain->customer()->find_one()->loginname. ')<br>';

		foreach ($domain->ip_ports()->find_many() as $ip) {
			print $ip->ip.':'.$ip->port.'<br>';
		}
	};*/
}

print "<pre>";

print_r($exportdata);
/*
foreach ($ips as $ip) {
	print '<h4>'.$ip->ip.':'.$ip->port.'</h4>';
	foreach ($ip->domains()->find_many() as $domain) {
		print $domain->domain. '<br>';
	}
}
*/