<?php

/**
 * Fired during plugin deactivation
 *
 * @link  https://designcontainer.no
 * @since 2.0.0
 *
 * @package    Passnado
 * @subpackage Passnado/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      2.0.0
 * @package    Passnado
 * @subpackage Passnado/includes
 * @author     Design Container AS <tech@designcontainer.no>
 */
class Passnado_Deactivator {


    /**
     * Wipe settings from database.
     *
     * @since  2.0.0
     * @author Rostislav Melkumyan
     */
    public static function deactivate() {
        delete_option('passnado_protect');
        delete_option('passnado_key');
        delete_option('passnado_logo');
        delete_option('passnado_message_layout');
        delete_option('passnado_message_title');
        delete_option('passnado_message_text');
        delete_option('passnado_login_link_text');
        delete_option('passnado_message_color');
        delete_option('passnado_checklist');
    }
}
