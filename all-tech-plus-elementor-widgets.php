<?php
/*
Plugin Name: All Tech Plus Elementor Widgets
Plugin URI: http://all-tech-plus.com
Description: Custom Elementor widgets for enhancing website functionality.
Version: 1.6.6
Initial: Aug 2023
Updated: Jan 2024 - added toggle to be able to enable/disable widget from loading
Author: Mark van Bellen, All Tech Plus, Rojales
Author URI: http://all-tech-plus.com
License: Donation!
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'elementor/elementor.php' ) ) {

    class My_Elementor_Widgets {

        protected static $instance = null;

        public static function get_instance() {
            if ( ! isset( static::$instance ) ) {
                static::$instance = new static;
            }

            return static::$instance;
        }

        protected function __construct() {
            // Register the admin menu
            add_action( 'admin_menu', [ $this, 'add_plugin_menu' ] );

            // Load widget files only if they are enabled in the settings
            if ( get_option( 'habeno_widget_enabled' ) ) {
                require_once('includes/habeno-widget.php');
                add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
            }
        }

        public function add_plugin_menu() {
            add_menu_page(
                'All Tech Plus Widgets',
                'ATP Widgets',
                'manage_options',
                'atp_widgets_settings',
                [ $this, 'render_settings_page' ],
                'dashicons-admin-plugins',
                99
            );
        }

        public function render_settings_page() {
            ?>
            <div class="wrap">
                <h1>All Tech Plus Widgets Settings</h1>
                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'atp_widget_settings_group' );
                    do_settings_sections( 'atp_widget_settings_page' );
                    submit_button();
                    ?>
                </form>
            </div>
            <?php
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
                'icon'  => 'fa fa-plug',
            ]
        );
    }
    add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );

    function my_elementor_init() {
        My_Elementor_Widgets::get_instance();
    }
    add_action( 'init', 'my_elementor_init' );

    // Register plugin settings
    function atp_widget_register_settings() {
        register_setting(
            'atp_widget_settings_group',
            'habeno_widget_enabled'
        );
        add_settings_section(
            'atp_widget_settings_section',
            'Widget Settings',
            '',
            'atp_widget_settings_page'
        );
        add_settings_field(
            'habeno_widget_enabled',
            'Enable Habeno Widget',
            'atp_widget_enable_callback',
            'atp_widget_settings_page',
            'atp_widget_settings_section'
        );
    }
    add_action( 'admin_init', 'atp_widget_register_settings' );


    // Callback function for the toggle switch
    function atp_widget_enable_callback() {
        ?>
        <label>
            <input type="checkbox" name="habeno_widget_enabled" value="1" <?php checked( get_option( 'habeno_widget_enabled' ), 1 ); ?> />
            Enable Habeno Widget
        </label>
        <?php
    }
}
