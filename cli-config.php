<?php

/*
 * Doctrine2 CLI configuration (must reside either in project root, or config/)
 */
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once 'lib/doctrine_init.php';

return ConsoleRunner::createHelperSet($em);