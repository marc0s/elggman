<?php
/**
 * Elggman subcribe action
 *
 */

$group_guid = (int) get_input('group');
$user_guid = (int) get_input('user');

// Let's see if we can get a group with the specified GUID
$group = get_entity($group_guid);
if (!$group || !elgg_instanceof($group, 'group')) {
	register_error(elgg_echo("elggman:subscription:failure"));
	forward(REFERER);
}

// Let's see if we can get a group with the specified GUID
$user = get_entity($user_guid);
if (!$user || !elgg_instanceof($user, 'user')) {
	register_error(elgg_echo("elggman:nopermissions"));
	forward(REFERER);
}

// If user is not in group, he joins
if (!$group->isMember($user)) {
	if (!groups_join_group($group, $user)) {
		register_error(elgg_echo("elggman:nopermissions"));
		forward(REFERER);
	}
}

//check to see if the user has already subscribed
if (check_entity_relationship($user_guid, 'notifymailshot', $group_guid)) {
	system_message(elgg_echo("elggman:alreadysubscribed"));
	forward(REFERER);
}

$subscribed = add_entity_relationship($user_guid, 'notifymailshot', $group_guid);

// tell subscription didn't work if that is the case
if (!$subscribed) {
	register_error(elgg_echo("elggman:subscription:failure"));
	forward(REFERER);
}

// send welcome email to user
notify_user($user->getGUID(), $group->owner_guid,
		elgg_echo('elggman:welcome:subject', array($group->name)),
		elgg_echo('elggman:welcome:body', array(
			$user->name,
			$group->name,
			"discussion/owner/$group_guid",
			elggman_get_group_mailinglist($group))
		));

system_message(elgg_echo("elggman:subscribed"));

// Forward to the subscription settings page
forward("elggman/view/$group_guid");
