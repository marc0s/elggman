<?php
/**
 * View a file
 *
 * @package Elggman
 */

$group = get_entity(get_input('guid'));

$user = elgg_get_page_owner_entity();

elgg_push_breadcrumb(elgg_echo('elggman'), "elggman/owner/$user->username");
elgg_push_breadcrumb($group->name);

$title = elgg_echo('elggman:owner', array($group->name));

$content = elgg_view_form('elggman/subscription/edit', array(), array());
$sidebar = elgg_view('elggman/sidebar/members', array('entity' => $group));

elgg_register_menu_item('title', array(
	'name' => 'elggman_unsubscribe',
	'text' => elgg_echo('elggman:unsubscribe'),
	'href' => "action/elggman/unsubscribe?user=$user->guid&group=$group->guid",
	'link_class' => 'elgg-button elgg-button-delete',
));

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
