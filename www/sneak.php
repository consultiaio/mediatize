<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'sneak.php');

$globals['favicon'] = 'img/favicons/favicon-sneaker.ico';

init_sneak();

// Check the tab options and set corresponging JS variables
if ($current_user->user_id > 0) {
	if (!empty($_REQUEST['friends'])) {
		$option = _('amigos');
	} elseif (!empty($_REQUEST['admin']) && $current_user->admin) {
		$option = _('admin');
	} else {
		$option = _('todos');
	}
	// Haanga::Load('sneak/tabs.html', compact('option'));
}
//////

// Start html
$globals['extra_css'][] = 'es/sneak.css';
if (!empty($_REQUEST['friends'])) {
	do_header(_('amigos'), _('chismosa'), sneak_menu_items($option), false, '', false, true);
} elseif ($current_user->user_id > 0 && !empty($_REQUEST['admin']) && $current_user->admin) {
	do_header(_('admin'), _('chismosa'), sneak_menu_items($option), false, '', false, true);
} else {
	do_header(_('chismosa'), _('chismosa'), sneak_menu_items($option), false, '', false, true);
}

$globals['site_id'] = SitesMgr::my_id();
Haanga::Load('sneak/base.html');



$globals['sneak_telnet'] = false;
Haanga::Load('sneak/form.html', compact('max_items'));

do_footer();



function sneak_menu_items($id) {
	global $globals, $current_user;

	$items = array();
	$items[] = new MenuOption(_('todos'), $globals['base_url'].'sneak', $id, _('todos'));
	$items[] = new MenuOption(_('amigos'), $globals['base_url'].'sneak?friends=1', $id, _('amigos'));
	if ($current_user->admin) {
		$items[] = new MenuOption(_('admin'), $globals['base_url'].'sneak?admin=1', $id, _('admin'));
	}
	$items[] = new MenuOption(_('consola'), $globals['base_url'].'telnet', $id, _('consola'));

	return $items;
}

