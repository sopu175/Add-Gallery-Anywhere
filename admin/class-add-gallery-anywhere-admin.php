<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sopu.me/
 * @since      1.0.0
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/admin
 * @author     Saif Islam <sopu175@gmail.com>
 */
class Add_Gallery_Anywhere_Admin
{

    /**
     * The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     */
    private $version;










    /**
     * Initialize the class and set its properties.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }












    /**
     * Register the stylesheets for the admin area.
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/add-gallery-anywhere-admin.css', array(), $this->version, 'all');

    }














    /**
     * Register the JavaScript for the admin area.
     */
    public function enqueue_scripts()
    {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/add-gallery-anywhere-admin.js', array('jquery'), $this->version, false);

    }













    /**
     * Register the media
     */
    public function loadmeida()
    {
        wp_enqueue_media();

    }















//	secure admin
    private function is_secured($nonce_field, $action, $post_id)
    {
        // Sanitize the nonce before using it
        $nonce = isset($_POST[$nonce_field]) ? sanitize_text_field(wp_unslash($_POST[$nonce_field])) : '';

        // Check if the nonce is empty or fails verification
        if ($nonce == '' || !wp_verify_nonce($nonce, $action)) {
            return false;  // Nonce verification failed
        }

        // Additional checks to ensure the request is legitimate
        if (!current_user_can('edit_post', $post_id)) {
            return false;  // Current user does not have permission to edit the post
        }

        if (wp_is_post_autosave($post_id)) {
            return false;  // Post is an autosave
        }

        if (wp_is_post_revision($post_id)) {
            return false;  // Post is a revision
        }

        return true;  // All checks passed, safe to proceed
    }
















    /**
     * Custom post for gallery
     */

    function custom_post_for_gallery()
    {


        $labels = array(
            'name' => 'Gallery Anywhere', // General name for the post type.
            'menu_name' => 'Gallery Anywhere',
            'singular_name' => 'Gallery Anywhere',
            'all_items' => 'All Galleries',
            'search_items' => 'Search Galleries',
            'add_new' => 'Add Gallery',
            'add_new_item' => 'Add New Gallery',
            'new_item' => 'New Gallery ',
            'view_item' => 'View Galleries',
            'edit_item' => 'Edit Galleries',
            'not_found' => 'No Galleries Found.',
            'not_found_in_trash' => 'Gallery not found in Trash.',
            'parent_item_colon' => 'Parent Gallery',
        );

        $args = array(
            'labels' => $labels,
            'description' => 'Gallery Anywhere',
            'menu_position' => 5,
            'menu_icon' => 'dashicons-format-gallery',
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'supports' => array('title'),
        );

        register_post_type('gallery_anywhere', $args);


    }















    /**
     * gallery admin add gallery meta
     */

    function gallery_admin_page()
    {

        add_meta_box(
            'omb_gallery_info',
            __('Uploads Gallery Images', 'add-gallery-anywhere'),
            array($this, 'omb_gallery_info'),
            array('gallery_anywhere')
        );

        add_meta_box('shortcode_message_metabox', __('Shortcode', 'add-gallery-anywhere'), array($this, 'shortcode_message_metabox'), array('gallery_anywhere'), 'side', 'high');
    }

















//    add gallery field with data show

    function omb_gallery_info($post)
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/add-gallery-anywhere-admin-display.php';

    }









    //save gallery images
    function save_gallery_image($post_id)
    {
        // First, verify the nonce before processing form data
        if (!isset($_POST['gallery_any_where_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['gallery_any_where_nonce']), 'add_gallery_any_where'))) {
            return $post_id; // Exit if nonce verification fails
        }

        // Sanitize the gallery shortcode
        $short_code = '[galleryanywhere id="' . $post_id . '"]';

        // Unslash and sanitize 'omb_images_url'
        $image_json = isset($_POST['omb_images_url']) ? sanitize_text_field(wp_unslash($_POST['omb_images_url'])) : ''; // Unslash before sanitizing
        $image_data = json_decode($image_json, true);

        // Ensure image data is valid and sanitized
        if (!empty($image_data) && is_array($image_data)) {
            // Unslash and sanitize 'show_per_image'
            $show_per_image = isset($_POST['show_per_image']) ? sanitize_text_field(wp_unslash($_POST['show_per_image'])) : 'Default'; // Unsplash before sanitizing
            $sanitized_show_per_image = sanitize_text_field($show_per_image);

            // Prepare data for saving
            $data = array(
                'gallery_url' => $image_data, // Full structured image data
                'shortcode' => sanitize_text_field($short_code), // Ensure shortcode is sanitized
                'show_per_image' => $sanitized_show_per_image, // Ensure the column setting is sanitized
            );

            // Update post meta with sanitized data
            update_post_meta($post_id, 'gallery_any_where', $data);
        }
    }














//    add shortcode meta box

    function shortcode_message_metabox()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/add-gallery-anywhere-admin-shortcode-display.php';



    }





//    add filter short code column in gallery anywhere post
    function custom_table_columns( $columns ) {
        $columns['shortcode'] = "<strong>Shortcode</strong>";
        return $columns;
    }






    //    add action for column out
    function custom_table_content( $column_name ,$post_ID) {
        if ($column_name == 'shortcode') {
            echo '[galleryanywhere id="'.esc_attr($post_ID).'"]';
        }

    }

}
