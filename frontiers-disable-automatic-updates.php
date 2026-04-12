<?php
namespace FrontiersDisableAllAutomatic;
// Ensure the file is not accessed directly
defined('ABSPATH') or die('Direct access not permitted.');
/**
 * Plugin Name: Frontiers Disable Automatic Updates
 * Plugin URI: https://github.com/frontiers-wp/frontiers-disable-automatic-updates
 * Description: Disables WordPress automatic updates for plugins, themes, and core.
 * Author: Edwin Bekedam
 * Author URI: https://github.com/frontiers-wp/frontiers-disable-automatic-updates
 * Donate link: https://paypal.me/EBekedam
 * Version: 1.0.0
 * License: GPL-2.0+
 */

// Define constant with current version
if (! defined( 'FRONTIERS_DISABLE_AUTOMATIC_UPDATES_VERSION' ) ) {
    define( 'FRONTIERS_DISABLE_AUTOMATIC_UPDATES_VERSION', '1.0.0' );
}

/**
 * Disables WordPress automatic updates for plugins, themes, and core.
 * Hooks into WordPress filters to prevent automatic updates.
 */
function frontiers_disable_automatic_updates() 
{
    // Prevent all plugin updates from being automatically installed
    add_filter('auto_update_plugin', '__return_false');
    // Disable plugins auto-update email notifications.
    add_filter( 'auto_plugin_update_send_email', '__return_false' );

    // Prevent all theme updates from being automatically installed
    add_filter('auto_update_theme', '__return_false');
    add_filter('core_update_skip_new_bundled', '__return_true');
    // Disable themes auto-update email notifications.
	add_filter( 'auto_theme_update_send_email', '__return_false' );

    // Prevent WordPress core from automatically updating
    add_filter('auto_update_core', '__return_false');
    add_filter('wp_auto_update_core', '__return_false');
}

/**
 * Disables automatic core updates for users with specific capability.
 * Defines WP_AUTO_UPDATE_CORE as false if user has 'P_AUTO_UPDATE_CORE' capability.
 */
function frontiers_disable_automatic_core_updates() 
{
    if (current_user_can('update_core')) {
        define('WP_AUTO_UPDATE_CORE', false);
    }
}

// Hook the main update disable function to WordPress initialization
add_action('init', 'FrontiersDisableAllAutomatic\frontiers_disable_automatic_updates');

// Hook the core update disable function to admin initialization
add_action('admin_init', 'FrontiersDisableAllAutomatic\frontiers_disable_automatic_core_updates');
