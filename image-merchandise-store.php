<?php
/*
Plugin Name: Image Merchandise Store For Wordpress
Plugin URI: http://www.pixter-media.com/wordpress
Description: Enable printing of images on accessories directly from your website.
This plugin adds a button on top of images in your website. The button appears on hover only.
Author: Pixter Media
Author URI: https://www.pixter.me
Text Domain: pixter-me
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Version: 1.4

Copyright 2016 Pixter Media
*/

defined('ABSPATH') && defined('WPINC') || die;

require_once dirname(__FILE__) . '/shared_variables.php';
require_once dirname(__FILE__) . '/admin.php';
require_once dirname(__FILE__) . '/plugin_functions.php';


function plugins_loaded_image_merchandise_store()
{
    p1xtr_image_merchandise_store_plugin_loaded('image_merchandise_store');
}

add_action('plugins_loaded', 'plugins_loaded_image_merchandise_store', 999999);

function image_merchandise_store_activate()
{
    p1xtr_image_merchandise_store_activate('image_merchandise_store');
}

register_activation_hook(__FILE__, 'image_merchandise_store_activate');

function image_merchandise_store_activation_redirect($plugin)
{
    p1xtr_image_merchandise_store_activation_redirect($plugin , 'image_merchandise_store');
}

add_action('activated_plugin', 'image_merchandise_store_activation_redirect');


//	function image_merchandise_store_init()
//	{
//		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
//	//	wp_enqueue_script( 'pixter-me-global', 'http://ddd.rrr.com/x.js', array(), '0.1', true );
//	}
//	add_action( 'init', 'image_merchandise_store_init');

function show_image_merchandise_store()
{
    return p1xtr_image_merchandise_store_show_plugin('image_merchandise_store');
}

function image_merchandise_store_inline_script()
{
    p1xtr_image_merchandise_store_inline_script('image_merchandise_store');
}

add_action('wp_footer', 'image_merchandise_store_inline_script', 99999);

/***
 * Added By Itay 20/9/2016
 */

function image_merchandise_store_register_notice()
{
    p1xtr_image_merchandise_store_register_notice('image_merchandise_store', 'Pixter.me for Merchandise');
}

add_action('admin_notices', 'image_merchandise_store_register_notice');


/***
 * Added By Itay 20/9/2016
 */

function image_merchandise_store_toggle_psk_notice()
{
    p1xtr_image_merchandise_store_psk_notice('image_merchandise_store', 'Pixter.me for Merchandise');
}

add_action('admin_notices', 'image_merchandise_store_toggle_psk_notice');


function image_merchandise_store_eventStage($url)
{
    $data = array(
        "storename" => get_bloginfo('name'),
        "website" => get_home_url(),
        "lang" => get_bloginfo('language'),
        "uid" => get_option('p1xtr_uid'),
        "plugin_uid" => get_option('image_merchandise_store_uid'),
        "plugin_ver" => get_option('image_merchandise_store_ver'),
        "plugin_db_ver" => get_option('image_merchandise_store_db_ver'),
        "wp_ver" => get_bloginfo('version'),
        "php_ver" => phpversion(),
    );
    $data_string = json_encode($data);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
    );

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    //execute post
    $result = trim(curl_exec($ch));

    curl_close($ch);

    return $result;

}


function image_merchandise_store_active()
{
    $image_merchandise_store_user = get_option('image_merchandise_store_user');
    global $image_merchandise_store_admin_tools;

    $image_merchandise_store_admin_tools->init_options();

    $apiUrl = P1XTR_API_BASE_URL . "/api/v2/publisher/activate_wp?user=wp&api_key=" . get_option('image_merchandise_store_user') . "&plugin_name=" . "image_merchandise_store";

    image_merchandise_store_eventStage($apiUrl);

    if(empty($image_merchandise_store_user)){
        $image_merchandise_store_admin_tools->registerGuestUser();
    }

}

register_activation_hook(__FILE__, 'image_merchandise_store_active');


function image_merchandise_store_deactivation()
{
    $apiUrl = P1XTR_API_BASE_URL . "/api/v2/publisher/deactivate_wp?user=wp&api_key=" . get_option('image_merchandise_store_user') . "&plugin_name=" . "image_merchandise_store";

    image_merchandise_store_eventStage($apiUrl);
}

register_deactivation_hook(__FILE__, 'image_merchandise_store_deactivation');

