<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link  https://designcontainer.no
 * @since 2.0.0
 *
 * @package    Passnado
 * @subpackage Passnado/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Passnado
 * @subpackage Passnado/public
 * @author     Design Container AS <tech@designcontainer.no>
 */
class Passnado_Public {


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

	private $cookie_exp;
	private $protect;
	private $key;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @param  string $plugin_name The name of the plugin.
	 * @param  string $version     The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->cookie_exp  = time() + 7 * 24 * 60 * 60; // 1 Week

		$this->protect = get_option('passnado_protect', false);
		$this->key     = get_option('passnado_key');
	}

	/**
	 * Intializes the protection with the correct protection type
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @return mixed
	 */
	public function init_protection() {

		// Check with empty cause WordPress settings are weird
		// https://developer.wordpress.org/reference/functions/get_option/#description
		if (false === $this->is_protection_enabled()) return; // Return if protection is not enabled. 
		if (true === is_user_logged_in())             return; // Return if use is logged in
		if (true === $this->has_protection_param())   return; // Return if authenticated with url param
		if (true === $this->has_protection_cookie())  return; // Return if authenticated with cookie

		echo $this->render_message();
		die();
	}

	/**
	 * Check if Passnado protection is enabled
	 *
	 * @since  2.1.1
	 * @author Rostislav Melkumyan
	 * @return boolean
	 */
	private function is_protection_enabled() {
		if ("1" === $this->protect)  return true;
		if (true === $this->protect) return true;
		return false;
	}

	/**
	 * Check if user has the key parameter
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @return boolean
	 */
	private function has_protection_param() {
		if (true === empty($this->key))    return false; // Check if key is set in options
		if (false === isset($_GET['key'])) return false; // Check if key is set in param
		if ($this->key !== $_GET['key'])   return false; // Check if key matches param val

		// Set cookie if all checks have passed
		$this->set_protection_cookie($_GET['key']);
		return true;
	}

	/**
	 * Check if user has the correct protection cookie for auth
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @return boolean
	 */
	private function has_protection_cookie() {
		if (true === empty($this->key))                return false; // Check if key is set in options
		if (false === isset($_COOKIE['passnado_key'])) return false; // Check if cookie is set

		$decoded_key = base64_decode($_COOKIE['passnado_key']);
		if ($this->key !== $decoded_key)                return false; // Check if key matches cookie val

		return true;
	}

	/**
	 * Set protection key cookie
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @param  void
	 */
	private function set_protection_cookie($key) {
		$this->set_wpe_anti_cache_cookie();
		$encoded_key = base64_encode($key);
		setcookie('passnado_key', $encoded_key, $this->cookie_exp, "/");
	}

	/**
	 * set a fake logged-in user cookie to break out of
	 * wpe's caching as needed. Is only set if no other
	 * CMS logged-in-user cookie has been set already.
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 */
	private function set_wpe_anti_cache_cookie() {
		if ($this->has_logged_in_user_cookie()) return; // Return if cookie already exists.
		$fake_user = '_fake_user_';
		$cookie = 'wordpress_logged_in_' . md5($fake_user);
		$value = md5($fake_user);
		setcookie($cookie, $value, $this->cookie_exp, '/');
	}

	/**
	 * Determine if logged-in cookie is set.
	 * 
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @return boolean
	 */
	private function has_logged_in_user_cookie() {
		$prefix = 'wordpress_logged_in_';
		foreach ($_COOKIE as $cookie => $val) {
			if (0 === strpos($cookie, $prefix)) return true;
		}
		return false;
	}

	/**
	 * Renders the public message.
	 *
	 * @since  2.0.0
	 * @author Rostislav Melkumyan
	 * @return string HTML markup
	 */
	public function render_message() {
		$template = plugin_dir_path(dirname(dirname(__FILE__))) . 'public/partials/passnado-public-message.php';
		ob_start();
		include $template;
		return ob_get_clean();
	}
}
