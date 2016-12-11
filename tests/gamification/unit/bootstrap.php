<?php
/**
 * Prepares a minimalist framework for unit testing.
 */

$mainBootstrap = str_replace('gamification'.DIRECTORY_SEPARATOR.'unit', 'unit'.DIRECTORY_SEPARATOR,  __DIR__). 'bootstrap.php';

$testsFolder = str_replace(DIRECTORY_SEPARATOR. 'gamification' . DIRECTORY_SEPARATOR . 'unit', '', __DIR__);
define('JOOMLA_TESTS_FOLDER_UNIT', $testsFolder . DIRECTORY_SEPARATOR . 'unit'. DIRECTORY_SEPARATOR);
define('GAMIFICATION_TESTS_FOLDER', $testsFolder . DIRECTORY_SEPARATOR . 'gamification'. DIRECTORY_SEPARATOR);
define('GAMIFICATION_TESTS_FOLDER_UNIT', GAMIFICATION_TESTS_FOLDER . 'unit'. DIRECTORY_SEPARATOR);
define('GAMIFICATION_TESTS_FOLDER_SCHEMA', GAMIFICATION_TESTS_FOLDER_UNIT . 'schema'. DIRECTORY_SEPARATOR);
define('GAMIFICATION_TESTS_FOLDER_STUBS_DATA', GAMIFICATION_TESTS_FOLDER_UNIT . 'stubs'. DIRECTORY_SEPARATOR . 'data'. DIRECTORY_SEPARATOR);
define('GAMIFICATION_TESTS_FOLDER_STUBS_DATABASE', GAMIFICATION_TESTS_FOLDER_UNIT . 'stubs'. DIRECTORY_SEPARATOR . 'database'. DIRECTORY_SEPARATOR);

/**
 * Include the main bootstrap.
 */
require_once JOOMLA_TESTS_FOLDER_UNIT . 'bootstrap.php';
//include_once GAMIFICATION_TESTS_FOLDER_UNIT . 'config.php';

jimport('Prism.init');
jimport('Gamification.init');

// Register the core Gamification test classes.
JLoader::registerPrefix('GamificationTest', __DIR__ . '/core');