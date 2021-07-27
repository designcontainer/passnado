<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link  https://designcontainer.no
 * @since 2.0.0
 *
 * @package    Passnado
 * @subpackage Passnado/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      2.0.0
 * @package    Passnado
 * @subpackage Passnado/includes
 * @author     Design Container AS <tech@designcontainer.no>
 */
class Passnado {


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @access protected
	 * @var    Passnado_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @access protected
	 * @var    string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @access protected
	 * @var    string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 */
	public function __construct() {
		$this->version = PASSNADO_VERSION; // defined in ../passnado.php
		$this->plugin_name = 'passnado';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_settings_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Passnado_Loader. Orchestrates the hooks of the plugin.
	 * - Passnado_I18n. Defines internationalization functionality.
	 * - Passnado_Admin. Defines all hooks for the admin area.
	 * - Passnado_Blocks. Defines all blocks in the forms gutenberg editor.
	 * - Passnado_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @access private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-passnado-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		include_once plugin_dir_path(dirname(__FILE__)) . 'includes/admin/class-passnado-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		include_once plugin_dir_path(dirname(__FILE__)) . 'includes/public/class-passnado-public.php';

		/**
		 * The class responsible for plugin settings.
		 */

		include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-passnado-settings.php';

		$this->loader = new Passnado_Loader();
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @access private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Passnado_Admin($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('admin_menu', $plugin_admin, 'register_options_page');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @access private
	 */
	private function define_public_hooks() {
		$plugin_public = new Passnado_Public($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('template_redirect', $plugin_public, 'init_protection');
	}

	/**
	 * Setup plugin settings
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @access private
	 */
	private function define_settings_hooks() {
		$plugin_settings = new Passnado_Settings($this->get_plugin_name(), $this->get_version());
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since  2.0.0
	 * @return string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  2.0.0
	 * @return Passnado_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since  2.0.0
	 * @return string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
