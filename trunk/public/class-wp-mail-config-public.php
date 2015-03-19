<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://omnikrys.com
 * @since      1.0.0
 *
 * @package    Wp_Mail_Config
 * @subpackage Wp_Mail_Config/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Mail_Config
 * @subpackage Wp_Mail_Config/public
 * @author     Thomas Robertson <tom@omnikrys.com>
 */
class Wp_Mail_Config_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wp_mail_config    The ID of this plugin.
	 */
	private $wp_mail_config;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wp_mail_config       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wp_mail_config, $version ) {

		$this->wp_mail_config = $wp_mail_config;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Mail_Config_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Mail_Config_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->wp_mail_config, plugin_dir_url( __FILE__ ) . 'css/wp-mail-config-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Mail_Config_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Mail_Config_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->wp_mail_config, plugin_dir_url( __FILE__ ) . 'js/wp-mail-config-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Set the mail from email address
	 *
	 * @since     1.0.0
	 * @return    string    From email address for emails sent out
	 */
	public function wp_mail_from( $original_email_address ) {
		return 'no-reply@prevueinc.com';
	}
	
	/**
	 * Set the mail from name
	 *
	 * @since     1.0.0
	 * @return    string    From name for emails sent out
	 */
	public function wp_mail_from_name( $original_email_from ) {
		return 'Prevue, Inc';
	}
	
	/**
	 * Set the sender to the from in emails we send out
	 *
	 * @since     1.0.0
	 */
	public function phpmailer_init( $phpmailer ) {
		$phpmailer->Sender = $phpmailer->From;
	}
	
}
