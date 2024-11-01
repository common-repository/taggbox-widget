<?php
/**
 * Plugin Name:       Tagbox Widget
 * Plugin URI:        https://taggbox.com/widget/
 * Description:       Display your social media content with the Tagbox Wordpress plugin - including hashtags and user content - in a beautiful and richly interactive view.
 * Version:           3.4
 * Author:            Tagbox
 * Author URI:        https://taggbox.com/widget/
 */
if (!defined('WPINC'))
    die;
/* --Start-- Create Constant */
!defined('TAGGBOX_PLUGIN_VERSION') && define('TAGGBOX_PLUGIN_VERSION', '3.3');
!defined('TAGGBOX_PLUGIN_DIR_PATH') && define('TAGGBOX_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
!defined('TAGGBOX_PLUGIN_URL') && define('TAGGBOX_PLUGIN_URL', plugins_url() . "/taggbox-widget");
!defined('TAGGBOX_PLUGIN_REDIRECT_URL') && define('TAGGBOX_PLUGIN_REDIRECT_URL', get_admin_url(null, 'admin.php?page='));
!defined('TAGGBOX_APP_URL') && define('TAGGBOX_APP_URL', "https://app.taggbox.com/widget/");
!defined('TAGGBOX_PLUGIN_API_URL') && define('TAGGBOX_PLUGIN_API_URL', "https://app.taggbox.com/web-admin/plugin/");
!defined('TAGGBOX_PLUGIN_SOCIAL_LOGIN_CALL_BACK_URL') && define('TAGGBOX_PLUGIN_SOCIAL_LOGIN_CALL_BACK_URL', admin_url() . "admin.php?page=taggbox");
/* --End-- Create Constant */
include_once TAGGBOX_PLUGIN_DIR_PATH . "helper/helper.php";/* Include Helper File */
/* --Start-- Manage Setting Link */
function ___taggbox_SettingsLink($links) {
    array_unshift($links, '<a href="admin.php?page=taggbox">Settings</a>');
    return $links;
}
add_filter("plugin_action_links_" . plugin_basename(__FILE__), '___taggbox_SettingsLink');
/* --End-- Manage Setting Link */
/* --Start-- Add Js And Css */
function ___taggbox_plugin_scripts_css() {
    if (is_admin()) :
	/* CSS */
	wp_enqueue_style('wp_taggbox-style', TAGGBOX_PLUGIN_URL . '/assets/css/style.css', '', TAGGBOX_PLUGIN_VERSION);
	/* JS */
	wp_enqueue_script('jquery');
	wp_enqueue_script('wp_taggbox-jquery-validate', TAGGBOX_PLUGIN_URL . '/assets/js/jquery.validate.min.js', ['jquery'], TAGGBOX_PLUGIN_VERSION, true);
	wp_enqueue_script('wp_taggbox-script', TAGGBOX_PLUGIN_URL . '/assets/js/script.js', ['jquery'], TAGGBOX_PLUGIN_VERSION, true);

	$__taggbox__api_call_security_nones = wp_create_nonce('__taggbox__api_call_security_nones');
	wp_localize_script('wp_taggbox-script', '__taggbox__api_call_security_nones_object', ['__taggbox__api_call_security_nones' => $__taggbox__api_call_security_nones]);

	wp_localize_script('wp_taggbox-script', 'taggboxAjaxurl', ['ajax_url' => admin_url('admin-ajax.php')]);
	/* --Start-- Gutenberge */
	if (!function_exists("register_block_type")) :
	    return;
	else :
	    wp_register_script("editor-js", TAGGBOX_PLUGIN_URL . '/assets/js/editor/editor.js', ["wp-blocks", "wp-element", "wp-block-editor", "wp-components", "wp-i18n", "wp-data", "wp-compose"], rand(0000, 9999));
	    register_block_type("taggbox-block/taggbox", ["editor_script" => "editor-js", "editor_style" => "editor-css", "style" => "editor-style-css"]);
	endif;
    /* --End-- Gutenberge */
    endif;
    wp_enqueue_script('wp_taggbox-embed', TAGGBOX_PLUGIN_URL . '/assets/js/embed-lite.min.js', array(), TAGGBOX_PLUGIN_VERSION, true);
}
add_action("init", "___taggbox_plugin_scripts_css");
add_filter('script_loader_tag', function ($tag, $handle) {
    if ('embbedJs' !== $handle)
	return $tag;
    return str_replace(' src', ' defer src', $tag);
}, 10, 2);
/* --End-- Add Js And Css */
/* --Start-- Add Menus */
function ___taggbox_plugin_menus() {
    ob_start();
    ?>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 141.4 141.4" width="200px" height="200px">
        <title>Tagbox Icon</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1">
    	    <g id="Layer_2-2" data-name="Layer 2"><path fill="#ccc" d="M70.7,141.4a70.7,70.7,0,1,1,70.7-70.7A70.82,70.82,0,0,1,70.7,141.4Zm0-135.7a65,65,0,1,0,65,65A65,65,0,0,0,70.7,5.7Z" /></g>
    	    <g id="Layer_3" data-name="Layer 3"><path fill="#ccc" d="M133,70.7A62.4,62.4,0,1,1,70.6,8.3,62.42,62.42,0,0,1,133,70.7Z" /></g>
    	    <g id="Layer_4" data-name="Layer 4"><polygon points="115.4 45.3 26 45.3 26 73.2 51.9 73.2 51.9 107.2 90.5 73.2 115.4 73.2 115.4 45.3" /></g>
    	</g></g>
    </svg>
    <?php
    $svg = ob_get_clean();
    add_menu_page('Tagbox', 'Tagbox Widget', 'manage_options', 'taggbox', '___taggbox_view', 'data:image/svg+xml;base64,' . base64_encode($svg));
}
add_action("admin_menu", '___taggbox_plugin_menus');
/* --Start-- Add & Manage Views */
function ___taggbox_view() {
    if (!empty(___taggbox_user()->isLogin) && ___taggbox_user()->isLogin == 'yes') :
	include_once TAGGBOX_PLUGIN_DIR_PATH . "views/widgetView.php";
    else :
	include_once TAGGBOX_PLUGIN_DIR_PATH . "views/loginView.php";
    endif;
}
/* --End-- Add & Manage Views */
/* --End-- Add Menus */
/* --Start-- Manage Session And Generate Csrf Token */
function start_session() {
    if (!session_id())
	session_start();
}
add_action('init', 'start_session', 1);
function ___taggbox_generate_csrf_token() {
    if (empty($_SESSION['___taggbox_csrf']))
	$_SESSION['___taggbox_csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['___taggbox_csrf'];
}
/* --End-- Manage Session And Generate Csrf Token */
/* --Start-- Manage Ajax Calls */
add_action("wp_ajax_data", "___taggbox_data_ajax_handler");
function ___taggbox_data_ajax_handler() {
    if (!current_user_can('manage_options')) :
	return ___taggbox_exit_with_danger('You do not have sufficient permissions to access this page.');
    endif;
    if (empty($_REQUEST['param']))
	return false;
    $data = ___tagbox__sanitize_request_data($_REQUEST);
    $data = (object)$data;

    /* --Start-- Manage Ajax call Request Security */
    $__taggbox__apiCallSecurityNones = isset($data->__taggbox__api_call_security_nones) ? sanitize_text_field($data->__taggbox__api_call_security_nones) : '';
    if (!wp_verify_nonce($__taggbox__apiCallSecurityNones, '__taggbox__api_call_security_nones')) :
	return ___taggbox_exit_with_danger("Something went wrong please try after sometime");
    endif;
    /* --End-- Manage Ajax call Request Security */

    /* --Start__ Sanetize All Input */
    foreach ($data as $key => $value) :
	if (!in_array($key, ['email', 'password']))
	    ___taggbox_input_sanitize($value);
    endforeach;
    /* --End__ Sanetize All Input */
    $param = [];
    global $wpdb;
    $action = $data->param;
    switch ($action):
	case "taggboxLogin":
	    if (empty($data->email) || empty($data->password))
		return ___taggbox_exit_with_danger("Something went wrong please try after sometime");
	    /* --Start-- Manage Param Data */
	    $param['email'] = sanitize_email($data->email);
	    $param['password'] = $data->password;
	    /* --End-- Manage Param Data */
	    $response = ___taggbox_wp_api_call(TAGGBOX_PLUGIN_API_URL . 'api/login', $param, []);
	    unset($param);
	    $response = ___taggbox_manage_api_response($response);
	    if (___taggbox_login($response->data) == true):
		return ___taggbox_exit_with_success(["redirectUrl" => TAGGBOX_PLUGIN_REDIRECT_URL . 'taggbox']);
	    else:
		return ___taggbox_exit_with_danger();
	    endif;
	    break;
	case "taggboxLogout":
	    if (___taggbox_logout() == true)
		return ___taggbox_exit_with_success(["redirectUrl" => TAGGBOX_PLUGIN_REDIRECT_URL . 'taggbox']);
	    return ___taggbox_exit_with_danger();
	    break;
	case "updateWidgetAccordingUser":
	    $userDetails = ___taggbox_user();
	    $email = sanitize_email($userDetails->email);
	    $userId = sanitize_key($_REQUEST['userid']);
	    if (___taggbox_manage_active_widgets_user($userId) != true)
		return ___taggbox_exit_with_danger();
	    if ($userDetails->userId == $userId):
		___taggbox_manage_widget($email);
	    else :
		___taggbox_manage_widget($email, $userId);
	    endif;
	    return ___taggbox_exit_with_success();
	    break;

	case "taggboxRefresh":
	    $user = ___taggbox_user();
	    $email = sanitize_email($user->email);
	    $userId = sanitize_key($user->userId);
	    ___taggbox_manage_widget($email);
	    $response = ___taggbox_wp_api_call(TAGGBOX_PLUGIN_API_URL . 'api/collaborator', ['user_id' => $userId], 'Authorization:' . $user->accessToken);
	    $response = ___taggbox_manage_api_response($response);
	    if (___taggbox_login($response->data) == true)
		___taggbox_manage_collaborator($response->collaborators, $userId);
	    foreach ($response->collaborators as $res):
		___taggbox_manage_widget($email, $res->id);
	    endforeach;
	    ___taggbox_manage_active_widgets_user($userId);
	    return ___taggbox_exit_with_success();
	    break;
	default:
	    return ___taggbox_exit_with_danger();
    endswitch;
    wp_die();
}
/* --End-- Manage Ajax Calls */
/* --Start-- Manage Social Login */
if (isset($_GET['code']) && $_GET['code'] == 200 && isset($_GET['csrf'])) {
    if (!session_id())
	session_start();
    /* --Start-- Manage  Request Security */
    $___taggbox_csrf = sanitize_text_field($_GET['csrf']);
    $___taggbox_sessionCsrfToken = $_SESSION['___taggbox_csrf'];
    unset($_SESSION['___taggbox_csrf']);
    if (!hash_equals($___taggbox_sessionCsrfToken, $___taggbox_csrf)) {
	header('Location: ' . TAGGBOX_PLUGIN_REDIRECT_URL . 'taggbox&error=s-w-r');
	exit();
    }
    /* --End-- Manage  Request Security */
    if (isset($_POST['response'])):
	$decoded_data = base64_decode($_POST['response']);
	$response = json_decode($decoded_data, true);
	$response['user_id'] = sanitize_key($response['user_id']);
	$response['owner'] = sanitize_key($response['owner']);
	$response['name'] = sanitize_text_field($response['name']);
	$response['firstName'] = sanitize_text_field($response['firstName']);
	$response['lastName'] = sanitize_text_field($response['lastName']);
	$response['emailId'] = sanitize_email($response['emailId']);
	$response['activeProduct'] = sanitize_key($response['activeProduct']);
	$response['accessToken'] = $response['accessToken'];
	$response['collaboratorlist'] = $response['collaboratorlist'];
	$response = (object)$response;
	if (___taggbox_login($response) == true):
	    header('Location: ' . TAGGBOX_PLUGIN_REDIRECT_URL . 'taggbox');
	    exit();
	endif;
    else :
	header('Location: ' . TAGGBOX_PLUGIN_REDIRECT_URL . 'taggbox&error=social-login-error');
	exit();
    endif;
}elseif (isset($_GET['code']) && $_GET['code'] == 400 && isset($_GET['csrf'])) {
    header('Location: ' . TAGGBOX_PLUGIN_REDIRECT_URL . 'taggbox&error=social-login-error');
    exit();
}
/* --End-- Manage Social Login */
/* --Start-- User Login */
function ___taggbox_login($response) {
    global $wpdb;
    $return = false;
    $user = ___taggbox_user($response->emailId);
    if (empty($user->email)) {
	if ($wpdb->query($wpdb->prepare("INSERT INTO wp_taggbox_user (userId, name, email, accessToken, isLogin) VALUES (%d, %s, %s, %s, %s)", $response->user_id, $response->name, $response->emailId, $response->accessToken, 'yes')))
	    $return = true;
    }else {
	if ($wpdb->query($wpdb->prepare("UPDATE wp_taggbox_user SET userId = %d, name = %s, email = %s, accessToken = %s, isLogin = %s WHERE email = %s", $response->user_id, $response->name, $response->emailId, $response->accessToken, 'yes', $response->emailId)))
	    $return = true;
    }
    if ($return == true):
	___taggbox_manage_widget($response->emailId);
	if (count(array($response->collaboratorlist))):
	    ___taggbox_manage_collaborator($response->collaboratorlist, $response->user_id);
	    foreach ($response->collaboratorlist as $collaborator):
		___taggbox_manage_widget($response->emailId, $collaborator->id);
	    endforeach;
	endif;
	___taggbox_manage_active_widgets_user($response->user_id);
    endif;
    return $return;
}
/* --End-- User Login */
/* --Start-- User Logout */
function ___taggbox_logout() {
    global $wpdb;
    $return = false;
    if ($wpdb->query($wpdb->prepare("UPDATE wp_taggbox_user SET isLogin = %s  WHERE isLogin = %s", "no", "yes")))
	$return = true;
    return $return;
}
/* --End-- User Logout */
/* --Start-- Get User Details */
function ___taggbox_user($email = null) {
    $user = '';
    global $wpdb;
    if ($email == null):
	$user = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_taggbox_user WHERE (isLogin = '%s')", 'yes'));
    else :
	$user = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_taggbox_user WHERE (email = '%s')", $email));
    endif;
    $user = (!empty($user)) ? $user[0] : '';
    return $user;
}
/* --End-- Get User Details */
/* --Start-- Get Collaborator Details */
function ___taggbox_collaborator($userId) {
    global $wpdb;
    return $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_taggbox_collaborator WHERE (userId = '%d')", $userId));
}
/* --End-- Get Collaborator Details */
/* --Start-- Manage Collaborator */
function ___taggbox_manage_collaborator($collaboratorList, $userId) {
    global $wpdb;
    $prevCollaboratorList = ___taggbox_convert_object_to_array(___taggbox_collaborator($userId));
    $collaboratorList = ___taggbox_convert_object_to_array($collaboratorList);
    $collaboratorListIds = [];
    if (is_array($collaboratorList))
	$collaboratorListIds = array_column($collaboratorList, 'id');
    if (is_array($prevCollaboratorList)):
	$prevCollaboratorListIds = array_column($prevCollaboratorList, 'collaboratorId');
	$commonCollaboratorIds = array_intersect($prevCollaboratorListIds, $collaboratorListIds);
	$prevCollaboratorListIds = array_diff($prevCollaboratorListIds, $commonCollaboratorIds); /* Delete */
	$collaboratorListIds = array_diff($collaboratorListIds, $commonCollaboratorIds); /* Insert */
    else :
	$prevCollaboratorListIds = [];
    endif;
    if (count($prevCollaboratorListIds)) : /* Delete */
	foreach ($prevCollaboratorListIds as $delId) :
	    if ($wpdb->query($wpdb->prepare("DELETE FROM  wp_taggbox_collaborator WHERE collaboratorId = %d AND userId = %d", $delId, $userId)))
		$wpdb->query($wpdb->prepare("DELETE FROM  wp_taggbox_widget WHERE userId = %d", $delId));
	endforeach;
    endif;
    foreach ($collaboratorList as $key => $collaborator) {
	if (in_array($collaborator['id'], $collaboratorListIds)): /* Insert */
	    $wpdb->query($wpdb->prepare("INSERT INTO wp_taggbox_collaborator (userId, collaboratorId, name) VALUES (%d, %d, %s)", $userId, $collaboratorList[$key]['id'], $collaboratorList[$key]['name']));
	elseif (in_array($collaborator['id'], $commonCollaboratorIds)):/* Update */
	    $wpdb->query($wpdb->prepare("UPDATE wp_taggbox_collaborator SET userId = %d, name = %s WHERE collaboratorId = %d AND userId = %d", $userId, $collaboratorList[$key]['name'], $collaborator['id'], $userId));
	endif;
    }
    return true;
}
/* --End-- Manage Collaborator */
/* --Start-- Get Widget */
function ___taggbox_widget($userId) {
    global $wpdb;
    return $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_taggbox_widget WHERE(userId = '%s')", $userId));
}
/* --End-- Get Widget */
/* --Start-- Get Active User */
function ___taggbox_active_widget_user() {
    global $wpdb;
    $activeUsers = $wpdb->get_results("SELECT * FROM wp_taggbox_active_widget_user");
    return empty($activeUsers) ? 0 : $activeUsers[0]->userId;
}
/* --End-- Get Active User */
/* --Start-- Manage Active Widget User */
function ___taggbox_manage_active_widgets_user($userId) {
    global $wpdb;
    $return = false;
    $activeWidgetUserId = ___taggbox_active_widget_user();
    if ($activeWidgetUserId == $userId):
	$return = true;
    else :
	if ($activeWidgetUserId == "") {
	    if ($wpdb->query($wpdb->prepare("INSERT INTO wp_taggbox_active_widget_user (userId) VALUES (%d)", $userId)))
		$return = true;
	}else {
	    if ($wpdb->query($wpdb->prepare("UPDATE wp_taggbox_active_widget_user SET userId = %d WHERE id = %d", $userId, 1)))
		$return = true;
	}
    endif;
    return $return;
}
/* --End-- Manage Active Widget User */
/* --Start-- Manage Widget */
function ___taggbox_manage_widget($userEmailId, $collaboratorId = null) {
    $user = ___taggbox_user($userEmailId);
    if ($user):
	$userId = $user->userId;
	$response = ___taggbox_wp_api_call(TAGGBOX_PLUGIN_API_URL . 'api/get_wall', ['user_id' => $userId, 'collaborator_id' => $collaboratorId], 'Authorization:' . $user->accessToken);
	if ($response->code == 200):
	    if ($collaboratorId != null && $collaboratorId != '')
		$userId = $collaboratorId;
	    global $wpdb;
	    $widgetData = ___taggbox_convert_object_to_array($response->data);
	    $widgetList = array_column($widgetData, "walls");
	    $prevWidgetList = ___taggbox_convert_object_to_array(___taggbox_widget($userId));
	    $widgetListIds = [];
	    if (is_array($widgetList))
		$widgetListIds = array_column($widgetList, 'id');
	    if (is_array($prevWidgetList)):
		$prevWidgetListIds = array_column($prevWidgetList, 'widgetId');
		$commonWidgetIds = array_intersect($prevWidgetListIds, $widgetListIds);
		$prevWidgetListIds = array_diff($prevWidgetListIds, $commonWidgetIds); //del
		$widgetListIds = array_diff($widgetListIds, $commonWidgetIds); //insert
	    else:
		$prevWidgetListIds = [];
	    endif;
	    if (count($prevWidgetListIds)) :/* Delete */
		foreach ($prevWidgetListIds as $delId):
		    $wpdb->query($wpdb->prepare("DELETE FROM  wp_taggbox_widget WHERE widgetId = %d AND userId = %d", $delId, $userId));
		endforeach;
	    endif;
	    foreach ($widgetList as $key => $widget) {
		if (in_array($widget['id'], $widgetListIds)) :/* Insert */
		    $wpdb->query($wpdb->prepare("INSERT INTO wp_taggbox_widget (userId,widgetId,name,widgetUrl,feedCount,networkCount,status) VALUES (%d,%d,%s,%s,%d,%d,%d)", $userId, $widgetList[$key]['id'], $widgetList[$key]['name'], $widgetList[$key]['url'], $widgetData[$key]['feed_count'], $widgetData[$key]['network_count'], $widgetList[$key]['status']));
		elseif (in_array($widget['id'], $commonWidgetIds)) :/* Update */
		    $wpdb->query($wpdb->prepare("UPDATE wp_taggbox_widget SET userId = %d,name = %s,widgetUrl = %s,feedCount = %d,networkCount = %d,status = %d WHERE widgetId = %d", $userId, $widgetList[$key]['name'], $widgetList[$key]['url'], $widgetData[$key]['feed_count'], $widgetData[$key]['network_count'], $widgetList[$key]['status'], $widget['id']));
		endif;
	    }
	endif;
    endif;
    return true;
}
/* --End-- Manage Widget */
/* --Start-- Manage Database */
/* --Start-- Create Database */
function ___taggbox_create_database_table_for_plugin() {
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_taggbox_user` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                     `userId` varchar(100) NOT NULL,
                     `name` varchar(100) NOT NULL,
                     `email` varchar(100) NOT NULL,
                     `accessToken` varchar(255) NOT NULL,
                     `isLogin` enum('no', 'yes') NOT NULL,
                     PRIMARY KEY(`id`)
                    ) ENGINE = InnoDB DEFAULT CHARSET = latin1");
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_taggbox_collaborator` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                     `userId` varchar(100) NOT NULL,
                     `collaboratorId` varchar(100) NOT NULL,
                     `name` varchar(100) NOT NULL,
                      PRIMARY KEY(`id`)
                    ) ENGINE = InnoDB DEFAULT CHARSET = latin1");
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_taggbox_widget` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                     `widgetId` varchar(100) NOT NULL,
                     `userId` varchar(100) NOT NULL,
                     `name` varchar(100) NOT NULL,
                     `widgetUrl` varchar(100) NOT NULL,
                     `feedCount` varchar(100) NULL,
                     `networkCount` varchar(100) NULL,
                     `status` int(1) NULL,
                      PRIMARY KEY(`id`)
                    ) ENGINE = InnoDB DEFAULT CHARSET = latin1");
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_taggbox_active_widget_user` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                    `userId` varchar(100) NOT NULL,
                     PRIMARY KEY(`id`)
                    ) ENGINE = InnoDB DEFAULT CHARSET = latin1");
}
register_activation_hook(__FILE__, '___taggbox_create_database_table_for_plugin');
/* --End-- Create Database */
/* --Start-- Drop Database */
function ___taggbox_drop_database_tables_for_plugin() {
    global $wpdb;
    $wpdb->query("DROP table IF EXISTS  wp_taggbox_user");
    $wpdb->query("DROP table IF EXISTS  wp_taggbox_collaborator");
    $wpdb->query("DROP table IF EXISTS  wp_taggbox_widget");
    $wpdb->query("DROP table IF EXISTS  wp_taggbox_active_widget_user");
}
register_uninstall_hook(__FILE__, '___taggbox_drop_database_tables_for_plugin');
register_deactivation_hook(__FILE__, '___taggbox_drop_database_tables_for_plugin');
/* --End-- Drop Database */
/* --End-- Manage Database */
/* --Start-- Create Short Code */
add_shortcode("taggbox", "taggboxPluginShortCode");
function taggboxPluginShortCode($attr) {
    extract(shortcode_atts(array('height' => '100%', 'width' => '100%',), $attr));
    $widgetId = (isset($attr['widgetid']) ? $attr['widgetid'] : '');
    if (!empty($widgetId) && is_numeric($widgetId) && (($width === '' || preg_match('/^\d+(px|%|)$/', $width)) && ($height === '' || preg_match('/^\d+(px|%|)$/', $height)))):
	$code = '';
	$code .= '<div class="taggbox" data-widget-id="' . $widgetId . '"></div>';
	$code .= '<script type="text/javascript" src="https://widget.taggbox.com/embed-lite.min.js"></script>';
    else:
	$code = '<span style="display: block;text-align: center;border: 1px solid #eee;padding: 5px 15px;background-color: #fafafa;">Invalid Parameters Provided In The Tagbox Shortcode.</span>';
    endif;
    return $code;
}
/* --End-- Create Short Code */
