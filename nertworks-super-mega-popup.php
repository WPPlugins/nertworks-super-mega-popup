<?php   
/* 
	Plugin Name: NertWorks Super Mega Popup 
	Plugin URI: http://www.nertworks.com 
	Description: Plugin for showing a popup on a specific url
	Author: Nickolas Ormond and Allen Smith
	Version: 1.0 
	Author URI: http://www.nertworks.com 
	*/  	
add_action('wp_footer', 'show_nertworks_popup');
function show_nertworks_popup(){
	$popup_url  = str_replace('/', "", get_option('url_of_popup1'));
	$page_url=str_replace('/', "", $_SERVER["REQUEST_URI"]);
	if(($page_url==$popup_url)||($popup_url==NULL)){
		echo '<script type="text/javascript">
	alert("'.get_option('super_mega_popup_message1').'");
	</script>';
	}
}
function nertworks_popup_settings_page() {
	?>
	<div class="wrap">
	<?php $logo=plugins_url('/images/nertworks_logo.png', __FILE__);?>
	<a href="http://nertworks.com" target="_blank"><img src="<?php echo $logo; ?>" style="width:20%;"></a>
	<h2>Super Mega Popup Options</h2>
	<hr></hr>
	<form method="post" action="options.php">
	<?php settings_fields( 'nertworks-popup-settings-group' ); ?>
	<?php do_settings_sections( 'nertworks-popup-settings-group' ); ?>
	<table class="form-table">
	<tr valign="top">
	<th scope="row"><strong>Popup Message: </strong></th>
	<td><input type="text" name="super_mega_popup_message1" value="<?php echo get_option('super_mega_popup_message1'); ?>" /></td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><strong>Where will Popup Appear?: </strong></th>
	<td><?php echo get_home_url();?>/<input type="text" name="url_of_popup1" value="<?php echo get_option('url_of_popup1'); ?>" /></td>
	
	</tr>
	<tr valign="top">
	<th scope="row"></th>
	<td><i>If you want it to show the popup everywhere on the website, leave it blank.  </i></td>		
	</tr>
	
	</table>
	
	<?php submit_button(); ?>

	</form>
	<hr></hr>
	<div id="donatePopipDiv">
	<i>Keep Nick and Allen awake with coffee to work on updates, features and bugs.  </i> 

	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">

	<input type="hidden" name="cmd" value="_s-xclick">

	<input type="hidden" name="hosted_button_id" value="D6FXJUCLE6RGY">

	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">

	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">

	</form>

	<img src="<?php echo plugins_url('/images/double_dragon.jpg', __FILE__); ?>" width="150">
	</div><!--donatePopipDiv-->
	</div>
	<?php }		
//Adding the CSS File
add_action( 'wp_enqueue_scripts', 'nertworks_super_popup_stylesheet' );

/**
* Enqueue plugin style-file
*/
function nertworks_super_popup_stylesheet() {
	// Respects SSL, Style.css is relative to the current file
	wp_register_style( 'prefix-style', plugins_url('style.css', __FILE__) );
	wp_enqueue_style( 'prefix-style' );
}
// create custom plugin settings menu
add_action('admin_menu', 'nertworks_create_popup_menu');

function nertworks_create_popup_menu() {
	//create new top-level menu
	add_menu_page('NertWorks Super Mega Popup', 'NW SuperPopup', 'administrator', __FILE__, 'nertworks_popup_settings_page',plugins_url('/images/icon16.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_nertworks_popup_settings' );
}
register_activation_hook(__FILE__, 'nertworks_mega_popup_plugin_activate');
add_action('admin_init', 'nertworks_popup_redirect');


function nertworks_mega_popup_plugin_activate() {
	add_option('my_plugin_do_activation_redirect_popup', true);
	update_option('super_mega_popup_message1', 'This is your Sample Message');
	update_option('url_of_popup1', 'sample-page');
}

function nertworks_popup_redirect() {
	if (get_option('my_plugin_do_activation_redirect_popup', false)) {
		delete_option('my_plugin_do_activation_redirect_popup');
		if(!isset($_GET['activate-multi']))
		{
			wp_redirect("?page=nertworks-super-mega-popup/nertworks-super-mega-popup.php");
		}
	}
}
function register_nertworks_popup_settings() {
	//register our settings
	register_setting( 'nertworks-popup-settings-group', 'super_mega_popup_message1' );
	register_setting( 'nertworks-popup-settings-group', 'url_of_popup1' );
}
?>
