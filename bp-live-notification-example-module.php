<?php
/* Plugin Name:  BuddyPress Live Notification Example Module
 * Plugin URI: http://buddydev.com/plugins/buddypress-live-notification/
 * Version: 1.0.0
 * Description: Adds a Facebook Like realtime notification for user
 * Author: Brajesh Singh
 * Author URI: http://buddydev.com/members/sbrajesh
 * License: GPL
 * Last Modified: March 11, 2015
 * 
 * */


class JG_BP_Live_Notification_Helper {
	/**
	 *
	 * @var JG_BP_Live_Notification_Helper
	 */
	private static $instance;
	
	private $url;
	private $path;
	
	
	private function __construct() {
		
		$this->url = plugin_dir_url( __FILE__ );
		$this->path = plugin_dir_path( __FILE__ );
		
		add_action( 'bp_include', array( $this, 'load' ) );
		
		add_action( 'bp_init', array( $this, 'unload_assets' ) );
		
		add_action( 'bp_enqueue_scripts', array( $this, 'load_css' ) );
		add_action( 'bp_enqueue_scripts', array( $this, 'load_js' ) );
		
		add_action( 'wp_footer', array( $this, 'in_footer' ) );
		add_action( 'in_admin_footer', array( $this, 'in_footer' ) );
		
	}
	
	/**
	 * 
	 * @return JG_BP_Live_Notification_Helper
	 */
	public static function get_instance() {
		
		if( ! isset( self::$instance ) )
				self::$instance = new self();
		
		return self::$instance;
		
		
	}
	
	public function load() {
		
		
		
	}
	

	public function unload_assets() {
		
		wp_deregister_style( 'achtung_css' );
		
		wp_deregister_script( 'achtung_js' );
	}
	/**
	 * Load required js
	 * 
	 * @return type
	 */
	public function load_js() {

		if( ! is_user_logged_in() || is_admin() && bpln_disable_in_dashboard() )
			return;
		
		wp_enqueue_script( '' );
		
		wp_register_script( 'jquery-notify', $this->url . 'assets/notify/js/jquery.notify.min.js', array( 'bpln_js') );
		wp_enqueue_script( 'jquery-notify' );
	}
	
	/**
	 * Load CSS file
	 * 
	 * @return type
	 */
	public function load_css() {
    
		if( ! is_user_logged_in() || is_admin() && bpln_disable_in_dashboard() )
			return;
    
		
		wp_register_style( 'jquery-notify',$this->url . 'assets/notify/css/jquery.notify.css' );
		wp_enqueue_style( 'jquery-notify' );
		
	}
	
	
	public function in_footer() { ?>
		
<script type='text/javascript'>
 
jQuery(document).ready( function (){
	var timeout = bpln.timeout*1000;
	bpln.notify = function (message ) {
		
		notify({

		//alert | success | error | warning | info
		type: "info", 
		title: "Right Now:",

		//custom message
		message: message,

		position: {

		  //right | left | center
		  x: "left", 

		  //top | bottom | center
		  y: "bottom" 
		},

		// notify icon
		icon: '<img src="<?php echo $this->url;?>assets/notify/images/paper_plane.png" />', 

	//normal | full | small
	size: "normal", 

	overlay: false, 
	closeBtn: true, 
	overflowHide: false, 
	spacing: 20, 

	//default | dark-theme
	theme: "default", 

	//auto-hide after a timeout
	autoHide: true, 

	// timeout
	delay: timeout, 

	// callback functions
	onShow: null, 
	onClick: null, 
	onHide: null, 

	//custom template
	template: '<div class="notify"><div class="notify-text"></div></div>'

	});
	}
});

</script>
				
	<?php }
	
}

JG_BP_Live_Notification_Helper::get_instance();