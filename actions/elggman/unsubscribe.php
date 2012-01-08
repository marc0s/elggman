<?php
/**
 * Elggman unsubcribe action
 *
 * @package Elggman
 */

$group_guid = (int) get_input('group');
$user_guid = (int) get_input('user');

// Let's see if we can get a group with the specified GUID
$group = get_entity($group_guid);
if (!$group || !elgg_instanceof($group, 'group')) {
	register_error(elgg_echo("elggman:unsubscription:failure"));
	forward(REFERER);
}

// Let's see if we can get a group with the specified GUID
$user = get_entity($user_guid);
if (!$user || !elgg_instanceof($user, 'user')) {
	register_error(elgg_echo("elggman:nopermissions"));
	forward(REFERER);
}

$unsubscribed = remove_entity_relationship($user_guid, 'notifymailshot', $group_guid);

// tell unsubscription didn't work if that is the case
if (!$unsubscribed) {
	register_error(elgg_echo("elggman:unsubscription:failure"));
	forward(REFERER);
}

system_message(elgg_echo("elggman:unsubscribed"));

// Forward to the group profile
forward($group->getURL());
