<?php

/**
 * The public-facing functionality of the plugin.
 *
 * This class handles the public-facing hooks and actions of the plugin.
 * It is responsible for enqueuing styles and scripts that are used on the front-end.
 *
 * @link       https://sopu.me/
 * @since      1.0.0
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for enqueuing public-facing stylesheets
 * and JavaScript. This class also manages the plugin's frontend assets.
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/public
 * @author     Saif Islam <sopu175@gmail.com>
 */
class Add_Gallery_Anywhere_Public
{

    /**
     * The ID of this plugin.
     *
     * @var string
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @var string
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * This method enqueues the necessary CSS files used on the frontend,
     * including Bootstrap, LightGallery, and custom plugin styles.
     */
    public function enqueue_styles()
    {


        // Enqueue the main LightGallery CSS from the CDN
        wp_enqueue_style(
            $this->plugin_name . 'fancybox-css',
            'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css',
            array(),
            $this->version,
            'all'
        );



        // Optionally, you can enqueue your own custom styles for your plugin
        wp_enqueue_style(
            $this->plugin_name . 'custom-style',
            plugin_dir_url(__FILE__) . 'css/add-gallery-anywhere-public.css',
            array(),
            $this->version,
            'all'
        );


    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * This method enqueues the necessary JavaScript files used for the gallery functionality.
     */

    public function enqueue_scripts()
    {

        // Enqueue the main LightGallery JS from the CDN (minified version)
        wp_enqueue_script(
            $this->plugin_name . 'fancybox-js',
            'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', // Corrected CDN
            array('jquery'),
            $this->version,
            false
        );


        // Optionally, enqueue your own custom JavaScript for your plugin
        wp_enqueue_script(
            $this->plugin_name . 'custom-script',
            plugin_dir_url(__FILE__) . 'js/add-gallery-anywhere-public.js',
            array('jquery', 'lightgallery-js'), // Ensure LightGallery JS is loaded first
            $this->version,
            false
        );
    }


}

