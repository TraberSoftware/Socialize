<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['module']['socialize'] = array(
	'module' => "Socialize",
    'name' => "Socialize Module",
	'description' => "Social Like and Share buttons for your website",
	'author' => "Traber Software",
	'version' => "1.0",

	/*
	'install' => 'install.php',
	'migrate' => 'migrate.php',
	'uninstall' => 'uninstall.php',
	*/

	'uri' => '',
	'has_admin'=> FALSE,
	'has_frontend'=> FALSE,

	// Array of resources
	// These resources will be added to the role's management panel
	// to allow / deny actions on them.
	'resources' => array(
		/*
		 * Default added resource : 'module/<module_key>'
		 *
		 * Important :
		 * 		The module has one default resource : 'access'
		 * 		If the main checkbox is checked for one role in the module's permissions,
		 * 		the role will:
		 * 		- See the module icon on the dashboard if the module has one admin panel
		 * 		- Have the module link in the menu "Modules" if the module has one admin panel
		 *
		 * Usage : Authority::can('access', 'module/<module_key>')
		 *
		 * Actions based rules (Added with this config file) :
		 * '<resource_key>' => array(
		 *		'title' => 'Resource title',
		 *		'actions' => '<action_key_1>, <action_key_2>, <action_key_3>',
		 *		'description' => 'Description of the resource in the role panel'
		 * )
		 * Usage : Authority::can('<action_key_1>', 'module/<module_key>/<resource_key>')
		 */
	),
);

return $config['module']['socialize'];
