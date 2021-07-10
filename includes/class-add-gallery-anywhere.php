<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://sopu.me/
 * @since      1.0.0
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/includes
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
 * @since      1.0.0
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/includes
 * @author     Saif Islam <sopu175@gmail.com>
 */
class Add_Gallery_Anywhere
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     */
    public function __construct()
    {
        if (defined('ADD_GALLERY_ANYWHERE_VERSION')) {
            $this->version = ADD_GALLERY_ANYWHERE_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'add-gallery-anywhere';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-add-gallery-anywhere-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-add-gallery-anywhere-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-add-gallery-anywhere-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-add-gallery-anywhere-public.php';


        $this->loader = new Add_Gallery_Anywhere_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     */
    private function set_locale()
    {

        $plugin_i18n = new Add_Gallery_Anywhere_i18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Add_Gallery_Anywhere_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('init', $plugin_admin, 'custom_post_for_gallery');
        $this->loader->add_action('admin_menu', $plugin_admin, 'gallery_admin_page');
        $this->loader->add_action('save_post', $plugin_admin, 'save_gallery_image');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'loadmeida', 10);
        $this->loader->add_filter( 'manage_edit-gallery_anywhere_columns',$plugin_admin, 'custom_table_columns' );
        $this->loader->add_action( 'manage_gallery_anywhere_posts_custom_column',$plugin_admin, 'custom_table_content',10,2 );



    }

    /**
     * Register all of the hooks related to the public-facing functionality
     */
    private function define_public_hooks()
    {

        $plugin_public = new Add_Gallery_Anywhere_Public($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');



//        add gallery short code
        add_shortcode('galleryanywhere', "gallery_add_anywhere_shortcode");
        function gallery_add_anywhere_shortcode($attributes)
        {
            if (!isset($attributes['id'])) {
                return '';
            }


            ob_start();
            $attributes = shortcode_atts(
                array(
                    'id' => 'no foo',

                ), $attributes, 'add-gallery-anywhere');

            $options = array(
                'p' => $attributes['id'],
                'post_type' => 'gallery_anywhere',
                'order' => 'ASC',
                'orderby' => 'menu',
                'posts_per_page' => -1,

            );
            $query = new WP_Query($options);
            ?>


            <?php

            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/class-add-gallery-anywhere-template.php';
            return ob_get_clean();
        }
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

}
