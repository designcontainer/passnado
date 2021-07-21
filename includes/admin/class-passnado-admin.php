<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://designcontainer.no
 * @since 2.0.0
 *
 * @package    Passnado
 * @subpackage Passnado/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Passnado
 * @subpackage Passnado/admin
 * @author     Design Container AS <tech@designcontainer.no>
 */
class Passnado_Admin {


    /**
     * The ID of this plugin.
     *
     * @since  2.0.0
     * @author Rostislav Melkumyan
     * @access private
     * @var    string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  2.0.0
     * @author Rostislav Melkumyan
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since  2.0.0
     * @author Rostislav Melkumyan
     */
    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name . '-admin',
            plugin_dir_url(dirname(dirname(__FILE__))) . 'build/css/app.admin.css',
            array('wp-components'),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since  2.0.0
     * @author Rostislav Melkumyan
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name . '-admin',
            plugin_dir_url(dirname(dirname(__FILE__))) . 'build/js/app.admin.js',
            array(
                'wp-api',
                'wp-i18n',
                'wp-components',
                'wp-element',
                'wp-editor',
            ),
            $this->version,
            true
        );
    }

    public function register_options_page() {
        add_options_page('Passnado', 'Password protection', 'manage_options', 'passnado', array($this, 'options_page'));
    }

    public function options_page() {
        // Add a wrapper to content to.
        echo '<div id="' . $this->plugin_name . '-settings-container"></div>';
        $this->enqueue_scripts();
        $this->enqueue_styles();
    }
}
