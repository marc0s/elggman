<?php
/**
 * Elggman plugin
 *
 * @package Elggman
 */

elgg_register_event_handler('init', 'system', 'elggman_init');

/**
 * Elggman plugin initialization functions.
 */
function elggman_init() {

	// register a library of helper functions
	elgg_register_library('elggman', elgg_get_plugins_path() . 'elggman/lib/elggman.php');

	// Extend CSS
	elgg_extend_view('css/elgg', 'elggman/css');
	
	elgg_extend_view('threads/sidebar', 'elggman/sidebar');

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('elggman', 'elggman_page_handler');
	
	// Register granular notification for this object type
	//register_notification_object('object', 'file', elgg_echo('file:newupload'));

	// Listen to notification events and supply a more useful message
	//elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'file_notify_message');

	// Register actions
	$action_path = elgg_get_plugins_path() . 'elggman/actions/elggman';
	elgg_register_action("elggman/subscribe", "$action_path/subscribe.php");
	elgg_register_action("elggman/unsubscribe", "$action_path/unsubscribe.php");
}

/**
 * Dispatches subscription pages.
 * URLs take the form of
 *  User's subscriptions: elggman/owner/<username>
 *  View subscription:    elggman/view/<guid>/
 *  Edit subscription:    elggman/edit/<guid>
 *
 * @param array $page
 * @return bool
 */
function elggman_page_handler($page) {

	$pages_dir = elgg_get_plugins_path() . 'elggman/pages/elggman';

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			include "$pages_dir/owner.php";
			break;
		case 'view':
			set_input('guid', $page[1]);
			include "$page_dir/view.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$page_dir/edit.php";
			break;
		default:
			return false;
	}
	return true;
}

function elggman_get_group_mailinglist($group) {
	if ($group->alias) {
		return $group->alias . '@' . elgg_get_plugin_setting('mailname', 'elggman');
	}
	return false;
}
