<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Function checkIPConfigured
 *
 * Checks whether an ip is actually configured on any interface on
 * the current host. Also takes into account FROXLOR_NODE_IPS environment
 * variable, if it is defined.
 *
 * @param string ip
 *
 * @return true if ip is configured, false otherwise
 */
function checkIPConfigured($ip) {

	$ips_env = getenv('FROXLOR_NODE_IPS');
	if ($ips_env!=false && strlen($ips_env)>0) {
		$all_ips = preg_split('/[,;\ ]+/', $ips_env);
	} else {
		$all_ips = preg_split('/\s+/', `hostname --all-ip-addresses`);
	}
	return array_search($ip, $all_ips) !== FALSE;
}

/**
 * Function checkDomainIPConfigured
 *
 * Checks whether a domain has at least one ipandport which is actually
 * configured on any interface of the current host
 *
 * @param int $domainid domain id
 *
 * @return true if ip is configured, false otherwise
 */

function checkDomainIPConfigured($domainid) {

	$result_stmt = Database::prepare(
		"SELECT `ipp`.`ip` FROM `".TABLE_DOMAINTOIP."` `dip`
			LEFT JOIN `".TABLE_PANEL_IPSANDPORTS."` `ipp` ON (`dip`.`id_ipandports` = `ipp`.`id`)
			   WHERE `dip`.`id_domain` = :domainid;");
	Database::pexecute($result_stmt, array('domainid' => (int) $domainid));

	while ($result = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
		if (checkIPConfigured($result['ip'])) {
			return true;
		}
	}
	return false;
}