<?php
/**
 * @package JAndrewsPlugin
 */

/**
 * Plugin Name: JAndrews Plugin
 * Plugin URI: www.mrjonathanandrews.com/jandrews-plugin
 * Description: This is my custom plugin based on Alessandro Castellani's tutorial series.
 * Version: 1.0.0
 * Author: Jonathan Andrews
 * Author URI: www.mrjonathanandrews.com
 * License: GPLv2 or later
 * Text Domain: jandrews-plugin
 */

// If this file is called directly, abort!
if( ! defined( 'ABSPATH' ) ) {
    die;
}

// require_once the Composer Autoload 
if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_jandrews_plugin() {
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_jandrews_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_jandrews_plugin() {
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_jandrews_plugin' );

/**
 * Initializes all of the core classes of the plugin
*/
if( class_exists( 'Inc\\Init' ) ) {
    Inc\Init::register_services();
}
