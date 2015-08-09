<?php

/**
 * This is just an example about how to use the ORM to display a list of customers,
 * domains and IPs. It is for development only and should never be put into any release.
 */

define('AREA', 'admin');
require './lib/init.php';
require './lib/doctrine_init.php';

$customers = $em->getRepository('Customer')->findAll();

foreach($customers as $customer) {
	print '<h3>' . $customer->name. ', '. $customer->firstname . ' (Admin:'. $customer->admin->loginname . ')</h3>';

	foreach($customer->domains as $domain) {
		print $domain->domain . /* ' (' .$domain->customer->find_one()->loginname. */'<br>';

		print '<pre>';
		print_r($domain->toArray());
		print '</pre>';
	}

	print '<pre>';
	Doctrine\Common\Util\Debug::dump($customer->domains);
	print '</pre>';


	/*
	foreach ($customer->domains()->find_many() as $domain) {
		print $domain->domain . ' (' .$domain->customer()->find_one()->loginname. ')<br>';

		foreach ($domain->ip_ports()->find_many() as $ip) {
			print $ip->ip.':'.$ip->port.'<br>';
		}
	};*/
	print "<br>";
}
/*
foreach ($ips as $ip) {
	print '<h4>'.$ip->ip.':'.$ip->port.'</h4>';
	foreach ($ip->domains()->find_many() as $domain) {
		print $domain->domain. '<br>';
	}
}
*/