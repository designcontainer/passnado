<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://designcontainer.no
 * @since 2.0.0
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

    /**
     * Register plugin settings
     *
     * @since  2.0.0
     * @author Rostislav Melkumyan
     * @access private
     * @var    string    $settings    Method for registering settings
     */
    private $settings;

    /**
     * Gets default settings
     *
     * @since  2.3.2
     * @author Alicia Harris
     * @access private
     * @var    string    $default_checklist    The default settings
     */
    private $default_checklist;

    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->default_checklist = $this->get_default_checklist();
        $this->settings = $this->register_settings();
    }

    /**
     * Get the default checklist items from csv file in plugin root folder
     *
     * @since 2.2.0
     * @author Rostislav Melkumyan
     * @return array Array of objects for tasks
     */
    public function get_default_checklist() {
        $file_name = 'passnado-checklist.csv';
        $csv_file = plugin_dir_path(dirname(dirname(__FILE__))) . $this->plugin_name . '/' . $file_name;

        // Get the file from the root directory in active theme if it exists.
        if (file_exists(get_template_directory() . '/' . $file_name)) {
            $csv_file = get_template_directory() . '/' . $file_name;
        }
        // Get the file from the root/passnado directory in active theme if it exists.
        if (file_exists(get_template_directory() . '/' . $this->plugin_name . '/' . $file_name)) {
            $csv_file = get_template_directory() . '/' . $this->plugin_name . '/' . $file_name;
        }

        $checklist_array = [];
        $row = 1;

        if (false !== ($handle = fopen($csv_file, "r"))) :
            while (false !== ($data = fgetcsv($handle, 1000, ","))) :
                $row++;
                $checklist_array[] = array(
                    'task'   => $data[0],
                    'done'   => $data[1] === 'true' ? true : false,
                    'custom' => false,
                );
            endwhile;
            fclose($handle);
        endif;

        return $checklist_array;
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
                'default'      => false,
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
            'passnado_message_color',
            array(
                'type'         => 'string',
                'show_in_rest' => true,
                'default'      => '#247cf9',
            )
        );

        register_setting(
            'passnado_options_group',
            'passnado_checklist',
            array(
                'type'         => 'array',
                'show_in_rest' => array(
                    'schema' => array(
                        'items' => array(
                            'type'       => 'object',
                            'properties' => array(
                                'task' => array(
                                    'type' => 'string',
                                ),
                                'done' => array(
                                    'type' => 'boolean',
                                ),
                                'custom' => array(
                                    'type' => 'boolean',
                                ),
                            ),
                        ),
                    ),
                ),
                'default' => $this->default_checklist,
            )
        );
    }
}
