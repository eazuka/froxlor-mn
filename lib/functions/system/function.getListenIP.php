<?php
/**
 * Function getListenIP
 *
 * returns the IP on which the webserver should actually listen.
 *
 * Reason: Since we don't bind the external IP to the worker node directly,
 * Apache cannot bind to it. So we set FROXLOR_LISTEN_IP in environment
 * which contains the actual IP on which Froxlor should listen.
 *
 * in case of Docker this is 0.0.0.0, if worker is a VM then it should be
 * the VM's internal IP
 *
 * @param string external_ip
 * @return mapped ip
 */
function getListenIP($external_ip) {
	$override_ip = getenv('FROXLOR_LISTEN_IP');
	if ($override_ip==false || strlen($override_ip)==0) {
		return $external_ip;
	} else {
		return $override_ip;
	}
}
