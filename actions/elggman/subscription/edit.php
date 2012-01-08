<?php
/**
 * Save subscription settings
 *
 * @package Elggman
 */


$group_guid = get_input('group');
$user_guid  = elgg_get_logged_in_user_guid();

$group = get_entity($group_guid);

if (!$group || !elgg_instanceof($group, 'group')) {
	forward(REFERER);
}

$options = get_input('options', array());

if ($group->isMember($user_guid)) {
	$obfuscated = check_entity_relationship($user_guid, 'obfuscated_groupmailshot', $group_guid);
	if (in_array('obfuscated', $options) && !$obfuscated) {
		add_entity_relationship($user_guid, 'obfuscated_groupmailshot', $group_guid);
	} elseif (!in_array('obfuscated', $options) && $obfuscated) {
		remove_entity_relationship($user_guid, 'obfuscated_groupmailshot', $group_guid);
	}
	
	$starred = check_entity_relationship($user_guid, 'starred_groupmailshot', $group_guid);
	if (in_array('starred', $options) && !$starred) {
		add_entity_relationship($user_guid, 'starred_groupmailshot', $group_guid);
	} elseif (!in_array('starred', $options) && $starred) {
		remove_entity_relationship($user_guid, 'starred_groupmailshot', $group_guid);
	}
}

forward(REFERER);
