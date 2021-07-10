<?php

/**
 * Fired during plugin activation
 *
 * @link       https://sopu.me/
 * @since      1.0.0
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/includes
 * @author     Saif Islam <sopu175@gmail.com>
 */
class Add_Gallery_Anywhere_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        flush_rewrite_rules();
	}

}
