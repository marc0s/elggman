<?php
/**
 * Mailing list sidebar
 * 
 * @package Elggman
 */

if(!elgg_is_logged_in()) {
	return true;
}

$user_guid = elgg_get_logged_in_user_guid();
$group_guid = elgg_get_page_owner_guid();

$content = '<p>' . elgg_echo('elggman:subscribe:info') . '</p>';

if(!elggman_is_user_subscribed($user_guid, $group_guid)) {
	$content .= elgg_view('output/url', array(
		'text' => elgg_echo('elggman:subscribe'),
		'href' => 'action/elggman/subscribe?' . http_build_query(array(
													'user' => $user_guid,
													'group' => $group_guid,
												)),
		'class' => 'elgg-button elgg-button-action',
		'is_action' => true,
		'is_trusted' => true,
	));
} else {
	$content .= elgg_view('output/url', array(
		'text' => elgg_echo('elggman:subscription:options'),
		'href' => "elggman/view/$group_guid",
		'class' => 'elgg-button',
		'is_trusted' => true,
	));
}
echo elgg_view_module('aside', elgg_echo('elggman'), $content);
