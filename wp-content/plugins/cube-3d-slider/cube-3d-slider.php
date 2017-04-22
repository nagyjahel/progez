<?php

/*

Plugin Name: Cube 3D Slider

Plugin URI: 

Version: 1.01

Description: Display beautiful 3D cube sliders

Author: Manu225

Author URI: 

Network: false

Text Domain: cube-3d-slider

Domain Path: 

*/

register_activation_hook( __FILE__, 'cube_3d_slider_install' );

register_uninstall_hook(__FILE__, 'cube_3d_slider_desinstall');



function cube_3d_slider_install() {



	global $wpdb;

	$cube_3d_slider_table = $wpdb->prefix . "cube_3d_sliders";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$sql = "

        CREATE TABLE `".$cube_3d_slider_table."` (
          id int(11) NOT NULL AUTO_INCREMENT,
          name varchar(50) NOT NULL,
          width int(11) NOT NULL,
          front_face_image varchar(500) NOT NULL,
          back_face_image varchar(500) NOT NULL,
          right_face_image varchar(500) NOT NULL,
          left_face_image varchar(500) NOT NULL,
          top_face_image varchar(500) NOT NULL,
          bottom_face_image varchar(500) NOT NULL,
          front_face_text text NOT NULL,
          back_face_text text NOT NULL,
          right_face_text text NOT NULL,
          left_face_text text NOT NULL,
          top_face_text text NOT NULL,
          bottom_face_text text NOT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

    ";

    dbDelta($sql);

}

function cube_3d_slider_desinstall() {

	global $wpdb;

	$cube_3d_slider_table = $wpdb->prefix . "cube_3d_sliders";

	//suppression des tables

	$sql = "DROP TABLE ".$cube_3d_slider_table.";";

	$wpdb->query($sql);

}

add_action( 'admin_menu', 'register_cube_3d_sliders_menu' );
function register_cube_3d_sliders_menu() {

	add_menu_page('Cube 3D Sliders', 'Cube 3D Sliders', 'edit_pages', 'cube_3d_sliders', 'cube_3d_sliders', plugins_url( 'images/icon.png', __FILE__ ), 28);
	add_submenu_page( 'cube_3d_sliders', 'Help', 'Help', 'edit_pages', 'cube_3d_sliders_help', 'cube_3d_sliders_help');

}

add_action('admin_print_styles', 'load_css_c3s' );
function load_css_c3s() {

    wp_enqueue_style( 'Cube3DSlidersStylesheet', plugins_url('css/admin.css', __FILE__) );
    wp_enqueue_style( 'jquery-ui-theme', '//code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css');

}

add_action( 'admin_enqueue_scripts', 'load_script_c3s' );
function load_script_c3s() {

	wp_enqueue_media();
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'jquery-ui-core');
    wp_enqueue_script( 'jquery-ui-accordion');

}

function cube_3d_sliders()
{
	global $wpdb;

	$cube_3d_slider_table = $wpdb->prefix . "cube_3d_sliders";

	//ajout ou édition d'un cube 3d
	if(sizeof($_POST))
	{
		if(is_numeric($_POST['id']))
			check_admin_referer( 'update_c3s_'.$_POST['id'] );
		else
			check_admin_referer( 'edit_c3s' );

		$query = "REPLACE INTO ".$cube_3d_slider_table." (`id`, `name`, `width`, `front_face_image`, `back_face_image`, `right_face_image`, `left_face_image`,
		`top_face_image`, `bottom_face_image`, `front_face_text`, `back_face_text`, `right_face_text`, `left_face_text`, `top_face_text`, `bottom_face_text`)
		VALUES (%d, %s, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)";

		$query = $wpdb->prepare( $query, $_POST['id'], sanitize_text_field(stripslashes_deep($_POST['name'])), $_POST['width'],
		sanitize_text_field(stripslashes_deep($_POST['front_face_image'])),	sanitize_text_field(stripslashes_deep($_POST['back_face_image'])),
		sanitize_text_field(stripslashes_deep($_POST['right_face_image'])), sanitize_text_field(stripslashes_deep($_POST['left_face_image'])),
		sanitize_text_field(stripslashes_deep($_POST['top_face_image'])), sanitize_text_field(stripslashes_deep($_POST['bottom_face_image'])),
		stripslashes_deep($_POST['front_face_text']),	stripslashes_deep($_POST['back_face_text']),
		stripslashes_deep($_POST['right_face_text']), stripslashes_deep($_POST['left_face_text']),
		stripslashes_deep($_POST['top_face_text']), stripslashes_deep($_POST['bottom_face_text'])
		);

		$wpdb->query( $query );		

	}


	$query = "SELECT * FROM ".$cube_3d_slider_table." ORDER BY name ASC";

	$cubes = $wpdb->get_results($query);

	include(plugin_dir_path( __FILE__ ) . 'views/cube_3d_sliders_list.php');
}

//help
function cube_3d_sliders_help()
{
	include(plugin_dir_path( __FILE__ ) . 'views/help.php');
}

//Ajax remove cube 3d
add_action( 'wp_ajax_remove_c3s', 'remove_c3s' );
function remove_c3s() {

	check_ajax_referer( 'remove_c3s' );

	if(current_user_can('edit_pages'))
	{
		if(is_numeric($_POST['id']))
		{
			global $wpdb;

			$cube_3d_slider_table = $wpdb->prefix . "cube_3d_sliders";

			$query = "DELETE FROM ".$cube_3d_slider_table." WHERE id = %d";

			$query = $wpdb->prepare( $query, $_POST['id'] );

			$wpdb->query( $query );

		}
	}

	wp_die();

}

add_shortcode('cube-3d-slider', 'display_cube_3ds');

function display_cube_3ds($atts) {

	if(is_numeric($atts['id']))
	{
		global $wpdb;

		$cube_3d_slider_table = $wpdb->prefix . "cube_3d_sliders";

		$query = "SELECT * FROM ".$cube_3d_slider_table." WHERE id = %d";

		$query = $wpdb->prepare( $query, $atts['id'] );

		$c3s = $wpdb->get_row( $query );

		if($c3s)
		{
			wp_enqueue_script( 'jquery');
			wp_enqueue_script( 'Cube3DSlider-front-js', plugins_url( 'js/front.js', __FILE__ ));
			wp_enqueue_style( 'Cube3DSliderFrontStylesheet', plugins_url('css/cube-3d-slider.css', __FILE__) );

			ob_start();
			include( plugin_dir_path( __FILE__ ) . 'views/cube-3d-slider.tpl.php' );
			return ob_get_clean();
		}
		else
			return 'Cube 3D Slider ID '.$atts['id'].' not found !';
	}
	else
		return 'ID must be numeric';

}

?>