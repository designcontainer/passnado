<?php

/**
 * @link     https://designcontainer.no
 * @since    2.0.0
 * @package  Password protect site
 *
 * Plugin Name: Passnado
 * Plugin URI:  https://designcontainer.no
 * Description: Password protect site
 * Version:     2.3.3
 * Author:      Design Container AS
 * Author URI:  https://designcontainer.no
 * License:     GNU General Public License version 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: passnado
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Current plugin version.
 * Rename this when releasing new versions.
 */
if (!defined('PASSNADO_VERSION')) {
	define('PASSNADO_VERSION', '2.3.3');
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-passnado-deactivator.php
 */
function deactivate_passnado() {
	include_once plugin_dir_path(__FILE__) . 'includes/class-passnado-deactivator.php';
	Passnado_Deactivator::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_passnado');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-passnado.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *f
 * @since 2.0.0
 */
function run_passnado() {
	$plugin = new Passnado();
	$plugin->run();
}
run_passnado();
