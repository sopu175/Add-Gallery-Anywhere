<?php

/**
 * The public-facing functionality of the plugin.
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
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/public
 * @author     Saif Islam <sopu175@gmail.com>
 */
class Add_Gallery_Anywhere_Public {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}





	/**
	 * Register the stylesheets for the public-facing side of the site.
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name.'boostrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'lightgallery_css', plugin_dir_url( __FILE__ ) . 'css/lightgallery.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'lightgallery_css2', plugin_dir_url( __FILE__ ) . 'css/lg-transitions.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/add-gallery-anywhere-public.css', array(), $this->version, 'all' );

	}





	/**
	 * Register the JavaScript for the public-facing side of the site.
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name.'bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'lightgallery', plugin_dir_url( __FILE__ ) . 'js/lightgallery.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'light_thumnail', plugin_dir_url( __FILE__ ) . 'js/lg-thumbnail.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'light_thumnail', plugin_dir_url( __FILE__ ) . 'js/lg-zoom.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'lg-video', plugin_dir_url( __FILE__ ) . 'js/lg-video.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/add-gallery-anywhere-public.js', array( 'jquery' ), $this->version, false );

	}

}
