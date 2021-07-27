<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://designcontainer.no
 * @since 1.0.0
 *
 * @package    Passnado
 * @subpackage Passnado/includes
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
class Passnado_Settings {


    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @author Rostislav Melkumyan
     * @access private
     * @var    string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @author Rostislav Melkumyan
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Register plugin settings
     *
     * @since  1.0.0
     * @author Rostislav Melkumyan
     * @access private
     * @var    string    $settings    Method for registering settings
     */
    private $settings;

    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->settings = $this->register_settings();
    }

    /**
     * Registers the Passnado settings
     *
     * @since  1.0.0
     * @author Rostislav Melkumyan
     */
    private function register_settings() {
        register_setting(
            'passnado_options_group',
            'passnado_protect',
            array(
                'type'         => 'boolean',
                'show_in_rest' => true,
                'default'      => true,
            )
        );

        register_setting(
            'passnado_options_group',
            'passnado_key',
            array(
                'type'         => 'string',
                'show_in_rest' => true,
                'default'      => '',
            )
        );

        register_setting(
            'passnado_options_group',
            'passnado_logo',
            array(
                'type'         => 'string',
                'show_in_rest' => true,
                'default'      => '',
            )
        );

        register_setting(
            'passnado_options_group',
            'passnado_message_layout',
            array(
                'type'         => 'string',
                'show_in_rest' => true,
                'default'      => 'default',
            )
        );

        register_setting(
            'passnado_options_group',
            'passnado_message_title',
            array(
                'type'         => 'string',
                'show_in_rest' => true,
                'default'      => 'This website is protected',
            )
        );

        register_setting(
            'passnado_options_group',
            'passnado_message_text',
            array(
                'type'         => 'string',
                'show_in_rest' => true,
                'default'      => 'Please login to view this website',
            )
        );

        register_setting(
            'passnado_options_group',
            'passnado_login_link_text',
            array(
                'type'         => 'string',
                'show_in_rest' => true,
                'default'      => 'Login',
            )
        );

        register_setting(
            'passnado_options_group',
            'passnado_checklist',
            array(
                'type'         => 'array',
                'show_in_rest' => array(
                    'schema' => array(
                        'type'  => 'array',
                        'checklist' => array(
                            'task' => 'string',
                            'done' => 'boolean',
                            'done' => 'boolean',
                        ),
                    ),
                ),
                'default' => array(
                    array(
                        'task'   => 'Setup your install',
                        'done'   => true,
                        'custom' => false,
                    ),
                    array(
                        'task'   => 'Install Passnado',
                        'done'   => true,
                        'custom' => false,
                    ),
                    array(
                        'task'   => 'Configure Cookiebot',
                        'done'   => false,
                        'custom' => false,
                    ),
                    array(
                        'task'   => 'Install the Cookiebot Popup plugin',
                        'done'   => false,
                        'custom' => false,
                    ),
                    array(
                        'task'   => 'Configure Google Tag Manager',
                        'done'   => false,
                        'custom' => false,
                    ),
                    array(
                        'task'   => 'Configure Google Analytics',
                        'done'   => false,
                        'custom' => false,
                    ),
                    array(
                        'task'   => 'Add all used plugins to the Composer file',
                        'done'   => false,
                        'custom' => false,
                    ),
                    array(
                        'task'   => 'Add a favicon',
                        'done'   => false,
                        'custom' => false,
                    ),
                    array(
                        'task'   => 'Add SMTP credentials',
                        'done'   => false,
                        'custom' => false,
                    ),
                    array(
                        'task'   => 'Update WordPress URLs',
                        'done'   => false,
                        'custom' => false,
                    ),
                )
            )
        );
    }
}
