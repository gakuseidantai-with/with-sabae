<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.1
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2018 Fuel Development Team
 * @link       http://fuelphp.com
 */

// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';

// Defines
// require APPPATH . 'define.php';

// Common Functinos
require APPPATH . 'functions.php';

\Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
	'Model_User'                           => APPPATH . 'classes/model/user.php',
	'Valid'                                => APPPATH . 'classes/validation/valid.php',
));

// Register the autoloader
\Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
\Fuel::$env = \Arr::get($_SERVER, 'FUEL_ENV', \Arr::get($_ENV, 'FUEL_ENV', getenv('FUEL_ENV') ?: \Fuel::PRODUCTION));

// Initialize the framework with the config file.
\Fuel::init('config.php');
