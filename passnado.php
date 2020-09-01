<?php

/**
 * @link     https://designcontainer.no
 * @since    1.1.0
 * @package  Password protect site
 *
 * Plugin Name: Passnado
 * Plugin URI:  https://designcontainer.no
 * Description: Password protect site
 * Version:     1.1.0
 * Author:      Design Container AS
 * Author URI:  https://designcontainer.no
 * License:     GNU General Public License version 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: passnado
 */

if (is_admin()) require_once plugin_dir_path( __FILE__ ) . 'admin/class-passnado-admin.php';
require_once plugin_dir_path( __FILE__ ) . 'public/class-passnado-public.php';
require_once plugin_dir_path( __FILE__ ) . 'public/class-passnado-message.php';
require_once plugin_dir_path( __FILE__ ) . 'public/class-passnado-fake-cookie.php';
