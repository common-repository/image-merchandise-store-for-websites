<?php
defined('ABSPATH') && defined('WPINC') || die;

require_once dirname(__FILE__) . '/admin-page-class/admin-page-class.php';
require_once dirname(__FILE__) . '/shared_variables.php';
require_once dirname(__FILE__) . '/admin_functions.php';

global $image_merchandise_store_admin_tools;
$image_merchandise_store_admin_tools = new p1xtr_image_merchandise_store_admin_tools('image_merchandise_store');
$image_merchandise_store_user = get_option('image_merchandise_store_user');

//if (empty($image_merchandise_store_user)) {
add_action('wp_ajax_register_image_merchandise_store_user', 'register_image_merchandise_store_user');

function register_image_merchandise_store_user()
{
    $isGuest = false;
    global $image_merchandise_store_admin_tools;
    $image_merchandise_store_admin_tools->register_user($isGuest);
    //p1xtr_image_merchandise_store_register_user('image_merchandise_store');
}

function image_merchandise_store_admin_page_register()
{
    p1xtr_image_merchandise_store_admin_page_register('image_merchandise_store', 'Pixter.me for Merchandise');
}

add_action('image_merchandise_store_admin_page_class_display_register_page', 'image_merchandise_store_admin_page_register');
//}else{
function image_merchandise_store_admin_before_page()
{
    p1xtr_image_merchandise_store_admin_before_page('image_merchandise_store');
}

add_action('image_merchandise_store_admin_page_class_before_page', 'image_merchandise_store_admin_before_page');
//}
/**
 * configure your options page
 */
$config = array(
    'menu' => array('top' => 'Pixter.me for Merchandise' .' settings'),
    'page_title' => 'Pixter.me for Merchandise',
    'page_header_text' => 'Here you can find configurations to your Pixter.me buttons, please also check your account on <a target="_blank" href="https://publishers.pixter.me/app/">Pixter.me</a> for more details.',
    'capability' => 'install_plugins',
    'option_group' => 'image_merchandise_store' .'_options',
    'id' => 'image_merchandise_store' .'_plugin',
    'fields' => $p1xtr_image_merchandise_store_fields,
    'icon_url' => plugins_url('admin-icon.png', __FILE__),
    'position' => 82,
    'plugin_name' => 'image_merchandise_store',
);
$options_panel = new BF_Admin_Page_Class($config);
