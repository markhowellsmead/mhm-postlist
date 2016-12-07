<?php
/*
Plugin Name: List posts using a shortcode
Plugin URI: https://github.com/markhowellsmead/mhm-postlist
Description: Add a shortcode to the page content, to include a simple list of recent blog posts. Posts will be displayed directly.
Author: Mark Howells-Mead
Version: 1.0.2
Author URI: https://markweb.ch/
Text Domain: mhm_postlist
Domain Path: /Resources/Private/Language
*/

if (version_compare($wp_version, '4.6', '<') || version_compare(PHP_VERSION, '5.3', '<')) {
    function mhm_postlist_compatability_warning()
    {
        echo '<div class="error"><p>'.sprintf(
            __('“%1$s” requires PHP %2$s (or newer) and WordPress %3$s (or newer) to function properly. Your site is using PHP %4$s and WordPress %5$s. Please upgrade. The plugin has been automatically deactivated.', 'mhm_postlist'),
            'PLUGIN NAME',
            '5.3',
            '4.6',
            PHP_VERSION,
            $GLOBALS['wp_version']
        ).'</p></div>';
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
    }
    add_action('admin_notices', 'mhm_postlist_compatability_warning');

    function mhm_postlist_deactivate_self()
    {
        deactivate_plugins(plugin_basename(__FILE__));
    }
    add_action('admin_init', 'mhm_postlist_deactivate_self');

    return;
} else {
    include 'Classes/Plugin.php';
}
