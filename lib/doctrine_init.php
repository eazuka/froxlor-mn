<?php
/*
 * Doctrine2 bootstrapper
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationRegistry;

require_once "vendor/autoload.php";
require_once "lib/userdata.inc.php";

// add our own Doctrine annotations to AnnotationRegistry
AnnotationRegistry::registerAutoloadNamespace('Froxlor\Annotations', array('lib/classes/ns/'));

// create Doctrine config
$isDevMode = true;
$proxyDir = null;
$cache = null; // TODO: we should use a cache
$config = Setup::createAnnotationMetadataConfiguration(array(), $isDevMode, $proxyDir, $cache, false);

// database configuration parameters
// taken from ../lib/userdata.inc.php
$conn = array(
	'driver' => 'pdo_mysql',
	'user' => $sql['user'],
	'password' => $sql['password'],
	'dbname' => $sql['db'],
	'host' => $sql['host']
);

// obtaining the entity manager
$em = EntityManager::create($conn, $config);
