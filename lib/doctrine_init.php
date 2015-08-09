<?php
/*
 * Doctrine2 bootstrapper
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";
require_once "lib/userdata.inc.php";


// initialize Doctrine with annotated model classes found
// in lib/classes/db
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/classes/db"), $isDevMode, null, null, false);

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
