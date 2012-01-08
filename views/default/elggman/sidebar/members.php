<?php
/**
 * Subscribed members sidebar
 * 
 * @package Elggman
 */

$user_guid = elgg_get_logged_in_user_guid();
$group_guid = elgg_get_page_owner_guid();

if(!elggman_is_user_subscribed($user_guid, $group_guid)) {
	return true;
}

$content = elgg_list_entities_from_relationship(array(
	'type' => 'user',
	'relationship' => 'notifymailshot',
	'relationship_guid' => $group_guid,
	'inverse_relationship' => true,
	'list_type' => 'gallery',
));

echo elgg_view_module('aside', elgg_echo('elggman:members'), $content);
