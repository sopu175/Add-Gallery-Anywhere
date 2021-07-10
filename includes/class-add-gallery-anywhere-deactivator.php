<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://sopu.me/
 * @since      1.0.0
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/includes
 * @author     Saif Islam <sopu175@gmail.com>
 */
class Add_Gallery_Anywhere_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        delete_post_meta_by_key( 'gallery_any_where' );

        $query_ads = array(
            'post_type' => 'gallery_anywhere',

        );

        $ads_post = get_posts($query_ads);

        foreach ( $ads_post as $myproduct ) {
            // Delete all products.
            wp_delete_post( $myproduct->ID, true); // Set to False if you want to send them to Trash.
        }
        flush_rewrite_rules();
	}

}
