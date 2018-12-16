<?php
/**
 * Plugin Name: Ministry Custom Post Type
 * Version: 1.0.0
 * Plugin URI: https://github.com/jmbarne3/ministries-cpt-plugin/
 * Author: Jim Barnes
 * Author URI: https://github.com/jmbarne3/
 * Description: Provides a custom post type and shortcodes for ministries.
 * Github Plugin URI: jmbarne3/ministry-cpt-plugin
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'JMB_MINISTRY__PLUGIN_URL', plugins_url( basename( dirname( __FILE__ ) ) ) );
define( 'JMB_MINISTRY__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'JMB_MINISTRY__STATIC_URL', JMB_PEOPLE__PLUGIN_URL . '/static' );
define( 'JMB_MINISTRY__PLUGIN_FILE', __FILE__ );


include_once 'includes/ministry-posttype.php';

if ( ! function_exists( 'jmb_ministry_plugin_activation' ) ) {
    function jmb_ministry_plugin_activation() {
        JMB_Ministry_PostType::register_posttype();
        flush_rewrite_rules();
    }

    register_activation_hook( JMB_MINISTRY__PLUGIN_FILE, 'jmb_ministry_plugin_activation' );
}

if ( ! function_exists( 'jmb_ministry_plugin_deactivation' ) ) {
    function jmb_ministry_plugin_deactivation() {
        flush_rewrite_rules();
    }

    register_deactivation_hook( JMB_MINISTRY__PLUGIN_FILE, 'jmb_ministry_plugin_deactivation' );
}

if ( ! function_exists( 'jmb_ministry_init' ) ) {
    function jmb_ministry_init() {
        add_action( 'init', array( 'JMB_Ministry_PostType', 'register_posttype' ), 10, 0 );
        add_action( 'acf/init', array( 'JMB_Ministry_PostType', 'add_fields' ), 10, 0 );
        add_action( 'posts_results', array( 'JMB_Ministry_PostType', 'add_meta_data' ), 10, 1 );
    }

    add_action( 'plugins_loaded', 'jmb_ministry_init' );
}
