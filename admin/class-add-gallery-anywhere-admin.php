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
        wp_enqueue_style($this->plugin_name . 'bootstraps-css', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version);
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/add-gallery-anywhere-admin.css', array(), $this->version, 'all');

    }














    /**
     * Register the JavaScript for the admin area.
     */
    public function enqueue_scripts()
    {

        wp_enqueue_script($this->plugin_name . 'bootstraps', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), $this->version, true);
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
        $nonce = isset($_POST[$nonce_field]) ? $_POST[$nonce_field] : '';

        if ($nonce == '') {
            return false;
        }
        if (!wp_verify_nonce($nonce, $action)) {
            return false;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return false;
        }

        if (wp_is_post_autosave($post_id)) {
            return false;
        }

        if (wp_is_post_revision($post_id)) {
            return false;
        }

        return true;

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
            __('Uploads Gallery Images', 'our-metabox'),
            array($this, 'omb_gallery_info'),
            array('gallery_anywhere')
        );

        add_meta_box('shortcode_message_metabox', __('Shortcode', 'our-metabox-shortcode'), array($this, 'shortcode_message_metabox'), array('gallery_anywhere'), 'side', 'high');
    }

















//    add gallery field with data show

    function omb_gallery_info($post)
    {
        $showimage_per_column = esc_attr(get_post_meta($post->ID, 'omb_images_id', true));
        $image_url = esc_url(get_post_meta($post->ID, 'omb_images_url', true));
        wp_nonce_field('gallery_any_where', 'gallery_any_where_nonce');


        $button_label = esc_attr('Upload Images','gallery_any_where');
        $title =  esc_attr('Add Gallery Images','gallery_any_where');
        $show_image_per = esc_attr('Show image per columns','gallery_any_where');
        $def = esc_attr('Default','gallery_any_where');
        $six = esc_attr('Six','gallery_any_where');
        $four = esc_attr('Four','gallery_any_where');
        $three = esc_attr('Three','gallery_any_where');
        $two = esc_attr('Two','gallery_any_where');
        $metabox_html = <<<EOD
<div class="fields">
	<div class="field_c">
	
		<div class="input_c">
			<label for="upload_images" class="mylabel">
		    <strong>{$title}</strong>
			<button class="button" id="upload_images" >{$button_label}</button>
</label>
<hr>
			<div class="clerfix"></div>
			<lable for="show_per_img" class="mylabel" style="margin-top:15px"><strong>{$show_image_per}</strong>
			
			<select name="show_per_image" id="show_per_img">
			    <option value="Default">{$def}</option>
			    <option value="6">{$six}</option>
			    <option value="4">{$four}</option>
			    <option value="3">{$three}</option>
			    <option value="2">{$two}</option>
            </select>
			</lable>
			<hr>
			<input type="hidden" name="omb_images_url" id="omb_images_url" value="{$image_url}"/>
		
			<div class="clearfix"></div>
			<div style="width:100%;height:auto;" id="images-container"></div>
			<div class="clearfix"></div>
			<hr>
		</div>
		<div class="float_c"></div>
	</div>
	
</div>
EOD;

        echo $metabox_html;
        require plugin_dir_path(__FILE__) . 'partials/add-gallery-anywhere-show-upload-gallery-images.php';
    }













    //save gallery images
    function save_gallery_image($post_id)
    {
        if (!$this->is_secured('gallery_any_where_nonce', 'gallery_any_where', $post_id)) {
            return $post_id;
        }

        $short_code = '[galleryanywhere id="' . $post_id . '"]';
        $image_url = isset($_POST['omb_images_url']) ? $_POST['omb_images_url'] : '';
        $image_url = esc_url($image_url,'gallery_any_where');

        if (empty($image_url)) {

        } else {
            $data = array(
                'gallery_url' => $image_url,
                'shortcode' => sanitize_text_field($short_code,'gallery_any_where'),
                'show_per_image' => sanitize_text_field($_POST['show_per_image'],'gallery_any_where')

            );

            update_post_meta($post_id, 'gallery_any_where', $data);
        }


    }













//    add shortcode meta box

    function shortcode_message_metabox()
    {

        $image_id = get_post_meta(get_the_ID(), 'gallery_any_where', true);
        $gallery_published = esc_attr('Published The Gallery First','gallery_any_where');
        if (!empty($image_id)) {
            $short = esc_attr($image_id['shortcode'],'gallery_any_where');
            $col = esc_attr($image_id['show_per_image'],'gallery_any_where');
            if ($col == null) {
                $col = esc_attr("Default (4 image per col)",'gallery_any_where');
            }
            $img_per_c = esc_attr('Image per column:','gallery_any_where');


            $metabox_html = <<<EOD
        <p><strong>{$short}</strong></p>
        <p><strong>{$img_per_c} {$col}</strong></p>

EOD;

            echo $metabox_html;
        } else {
            $metabox_html = <<<EOD
        <p><strong>{$gallery_published}</strong></p>
        

EOD;

            echo $metabox_html;
        }

    }





//    add filter short code column in gallery anywhere post
    function custom_table_columns( $columns ) {
        $columns['shortcode'] = "<strong>Shortcode</strong>";
        return $columns;
    }






    //    add action for column out
    function custom_table_content( $column_name ,$post_ID) {
        if ($column_name == 'shortcode') {
            echo sanitize_text_field('[galleryanywhere id="'.$post_ID.'"]');
        }

    }

}
