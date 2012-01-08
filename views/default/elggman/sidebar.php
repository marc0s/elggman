<?php
/**
 * Mailing list sidebar
 * 
 * @package Elggman
 */

if(!elgg_is_logged_in()) {
	return true;
}

$content = '<p>' . elgg_echo('elggman:subscribe:info') . '</p>';

$content .= elgg_view('output/url', array(
	'text' => elgg_echo('elggman:subscribe'),
	'href' => 'action/elggman/subscribe?' . http_build_query(array(
												'user' => elgg_get_logged_in_user_guid(),
												'group' => elgg_get_page_owner_guid(),
											)),
	'class' => 'elgg-button elgg-button-action',
	'is_action' => true,
	'is_trusted' => true,
));

echo elgg_view_module('aside', elgg_echo('elggman'), $content);
