<?php
/*
Plugin Name: All Tech Plus Elementor Widgets
Plugin URI: http://all-tech-plus.com
Description: Custom Elementor widgets for enhancing website functionality.
Version: 1.4
Author: Mark van Bellen, All Tech Plus, Rojales
Author URI: http://all-tech-plus.com
License: Donation!
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active( 'elementor/elementor.php' )) {



class My_Elementor_Widgets {

	protected static $instance = null;

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct() {
		require_once('includes/habeno-widget.php');
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}

	public function register_widgets() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Habeno_Mortgage_Widget() );
	}

}

function add_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'ATP',
		[
			'title' => esc_html__( 'All Tech Plus', 'textdomain' ),
			'icon' => 'fa fa-plug',
		]
	);
}
add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );


add_action( 'init', 'my_elementor_init' );
function my_elementor_init() {
	My_Elementor_Widgets::get_instance();
}







        }
