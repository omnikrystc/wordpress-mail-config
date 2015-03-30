<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://omnikrys.com
 * @since      1.0.0
 *
 * @package    Wp_Mail_Config
 * @subpackage Wp_Mail_Config/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Mail_Config
 * @subpackage Wp_Mail_Config/admin
 * @author     Thomas Robertson <tom@omnikrys.com>
 */
class Wp_Mail_Config_Admin {

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
	 * @param      string    $wp_mail_config       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wp_mail_config, $version ) {

		$this->wp_mail_config = $wp_mail_config;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->wp_mail_config, plugin_dir_url( __FILE__ ) . 'css/wp-mail-config-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->wp_mail_config, plugin_dir_url( __FILE__ ) . 'js/wp-mail-config-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add a submenu to the Settings menu
	 *
	 * @since    1.0.0
	 */
	public function admin_menu() {
	
		add_options_page(
			'Mail Config',
			'Mail Config',
			'administrator',
			'wp_mail_config_options',
			array($this, 'config_display')
		);
	
	}

	/**
	 * Provides default values for the General Options.
	 */
	function default_options() {
	
		$defaults = array(
				'from_address'		=>	'',
				'from_name'			=>	'',
				'sender_address'	=>	'',
				'hostname'			=>	'',
				'host'				=>	'',
				'port'				=>	'',
				'username'			=>	'',
				'password'			=>	'',
		);
	
		return apply_filters( 'wp_mail_config_default_options', $defaults );
	
	}
	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	function config_display( $active_tab = '' ) {
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">
		
			<div id="icon-themes" class="icon32"></div>
			<h2><?php _e( 'WordPress Mail Config Options', 'sandbox' ); ?></h2>
			<?php settings_errors(); ?>
			
			<?php if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET[ 'tab' ];
			} else if( $active_tab == 'test_email' ) {
				$active_tab = 'test_email';
			} else {
				$active_tab = 'config_options';
			} // end if/else ?>
			
			<h2 class="nav-tab-wrapper">
				<a href="?page=wp_mail_config_options&tab=config_options" class="nav-tab <?php echo $active_tab == 'config_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Config Options', 'wp_mail_config' ); ?></a>
				<a href="?page=wp_mail_config_options&tab=test_email" class="nav-tab <?php echo $active_tab == 'test_email' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Test Email', 'wp_mail_config' ); ?></a>
			</h2>
			
			<form method="post" action="options.php">
				<?php
				
					if( $active_tab == 'config_options' ) {
						
						settings_fields( 'wp_mail_config_options' );
						do_settings_sections( 'wp_mail_config_options' );

					} else if( $active_tab == 'test_email' ) {
					
						#settings_fields( 'email_test' );
						#do_settings_sections( 'wp_mail_config_options' );
					
					} else {
					
						settings_fields( 'wp_mail_config_options' );
						do_settings_sections( 'wp_mail_config_options' );
						
					} // end if/else
					
					submit_button();
				
				?>
			</form>
			
		</div><!-- /.wrap -->
	<?php
	} // end sandbox_theme_display
		
	/**
	 * Initializes the options page
	 */
	function initialize_options() {
	
		// If the theme options don't exist, create them.
		if( false == get_option( 'wp_mail_config_options' ) ) {
			add_option( 
				'wp_mail_config_options', 
				apply_filters( 
					'wp_mail_config_default_options', 
					$this->default_options() 
				) 
			);
		} // end if

		// register a section
		add_settings_section(
			'settings_section',			
			__( 'Email Options', 'wp_mail_config' ),
			array($this, 'wp_mail_config_options_callback'),
			'wp_mail_config_options'
		);

		// add fields
		add_settings_field(
			'from_address',
			__( 'From Address', 'wp_mail_config' ),
			array($this, 'from_address_callback'),
			'wp_mail_config_options',
			'settings_section',
			array(
				__( 'Address to use for the from field.', 'wp_mail_config' ),
			)
		);

		add_settings_field(
				'from_name',
				__( 'From Name', 'wp_mail_config' ),
				array($this, 'from_name_callback'),
				'wp_mail_config_options',
				'settings_section',
				array(
						__( 'Name to use for the from field.', 'wp_mail_config' ),
				)
		);
/*
		add_settings_field(
				'sender_address',
				__( 'Sender Address', 'wp_mail_config' ),
				array($this, 'sender_address_callback'),
				'wp_mail_config_options',
				'settings_section',
				array(
						__( 'Address to use as sender.', 'wp_mail_config' ),
				)
		);

		add_settings_field(
				'hostname',
				__( 'Hostname', 'wp_mail_config' ),
				array($this, 'hostname_callback'),
				'wp_mail_config_options',
				'settings_section',
				array(
						__( 'Hostname to use (HELO, message-id, etc).', 'wp_mail_config' ),
				)
		);

		add_settings_field(
				'host',
				__( 'Host', 'wp_mail_config' ),
				array($this, 'host_callback'),
				'wp_mail_config_options',
				'settings_section',
				array(
						__( 'Host server (SMTP).', 'wp_mail_config' ),
				)
		);

		add_settings_field(
				'port',
				__( 'Port', 'wp_mail_config' ),
				array($this, 'port_callback'),
				'wp_mail_config_options',
				'settings_section',
				array(
						__( 'Port (SMTP).', 'wp_mail_config' ),
				)
		);
		
		add_settings_field(
				'username',
				__( 'Username', 'wp_mail_config' ),
				array($this, 'username_callback'),
				'wp_mail_config_options',
				'settings_section',
				array(
						__( 'Username to use (SMTP, optional).', 'wp_mail_config' ),
				)
		);

		add_settings_field(
				'password',
				__( 'Password', 'wp_mail_config' ),
				array($this, 'password_callback'),
				'wp_mail_config_options',
				'settings_section',
				array(
						__( 'Password to use (SMTP, optional).', 'wp_mail_config' ),
				)
		);
*/		
		// register the fields with WordPress
		register_setting(
			'wp_mail_config_options',
			'wp_mail_config_options',
			array($this, 'wp_mail_config_options_validate')
		);
		
	}
	
	/*
	 * Callbacks, should probably make a class for handling the forms stuff...
	 * 
	 */
	
	/**
	 * callback for main config form
	 */
	function wp_mail_config_options_callback() {
		echo '<p>' . __( 'Configure email options for WordPress.', 'wp_mail_config' ) . '</p>';
	}

	/**
	 * callbacks for options fields
	 */
	public function from_address_callback($args) {
		$this->callback_helper('from_address', false);
	}

	public function from_name_callback() {
		$this->callback_helper('from_name', false);
	}

	public function sender_address_callback() {
		$this->callback_helper('sender_address', false);
	}

	public function hostname_callback() {
		$this->callback_helper('hostname', false);
	}

	public function host_callback() {
		$this->callback_helper('host', false);
	}

	public function port_callback() {
		$this->callback_helper('port', false);
	}

	public function username_callback() {
		$this->callback_helper('username', false);
	}

	public function password_callback() {
		$this->callback_helper('password', true);
	}
	
	public function wp_mail_config_options_validate( $input ) {
	
		// Create our array for storing the validated options
		$output = $input; //array();
	
		// Check and cleanup the values
		
		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'wp_mail_config_options_validate', $output, $input );
	
	}
	
	private function callback_helper($field_name, $is_password) {
		$options = get_option('wp_mail_config_options');
		$value = '';
		if( isset( $options[$field_name] ) ) {
			$value = esc_html( $options[$field_name] );
		}
		// Render the output
		echo '<input type="' . ($is_password ? 'password' : 'text') . '" id="' . $field_name . '" name="wp_mail_config_options[' . $field_name . ']" value="' . $value . '" />';
	
	}

}