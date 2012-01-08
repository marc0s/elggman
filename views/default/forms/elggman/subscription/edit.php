<?php
/**
 * Edit subscription settings
 *
 * @package Elggman
 */

$user = elgg_get_logged_in_user_entity();
$group = $vars['entity'];

$site_url = parse_url(elgg_get_site_url(), PHP_URL_HOST);
$option_values = array();

if (check_entity_relationship($user->guid, 'obfuscated_groupmailshot', $group->guid)) {
	$option_values[] = 'obfuscated';
}

if (check_entity_relationship($user->guid, 'starred_groupmailshot', $group->guid)) {
	$option_values[] = 'starred';
}

echo elgg_view('input/checkboxes', array(
	'options' => array(
		elgg_echo('elggman:obfuscated', array($user->username, $site_url)) => 'obfuscated',
		elgg_echo('elggman:starred') => 'starred',
		),
	'name' => 'options',
	'value' => $option_values,
	));

echo '<div class="elgg-foot">';

echo elgg_view('input/hidden', array(
	'name' => 'group',
	'value' => $group->guid,
	));

echo elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
	'class' => 'elgg-button-submit mtm',
	));

echo '</div>';
