<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 *
 */

define('AREA', 'admin');
require './lib/init.php';

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif(isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'nodes'
	|| $page == 'overview'
) {

	if ($action == '') {

		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_nodes");
		$fields = array(
			'name' => $lng['admin']['nodes']['name'],
			'image' => $lng['admin']['nodes']['image'],
			'tag' => $lng['admin']['nodes']['tag']
		);
		$paging = new paging($userinfo, TABLE_NODES, $fields);
		$nodes = '';
		$result_stmt = Database::prepare("SELECT * FROM `" . TABLE_NODES . "` " . $paging->getSqlWhere(false) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		Database::pexecute($result_stmt);
		$paging->setEntries(Database::num_rows());
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

			if ($paging->checkDisplay($i)) {
				$row = htmlentities_array($row);
				eval("\$nodes.=\"" . getTemplate("nodes/node") . "\";");
				$count++;
			}
			$i++;
		}

		eval("echo \"" . getTemplate("nodes/nodes") . "\";");

	} elseif ($action == 'delete'
		&& $id != 0
	) {
		$result_stmt = Database::prepare("SELECT `id`, `name` FROM `" . TABLE_NODES . "` WHERE `id` = :id");
		$result = Database::pexecute_first($result_stmt, array('id' => $id));

		if (isset($result['id']) && $result['id'] == $id)
		{
			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				$del_stmt = Database::prepare("
									DELETE FROM `" . TABLE_NODES . "`
									WHERE `id` = :id"
				);
				Database::pexecute($del_stmt, array('id' => $id));

				/*
				// also, remove connections to domains (multi-stack)
				$del_stmt = Database::prepare("
									DELETE FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_ipandports` = :id"
				);
				Database::pexecute($del_stmt, array('id' => $id));
				*/
				$log->logAction(ADM_ACTION, LOG_WARNING, 'deleted node "' . $result['name'] . '"');
				inserttask('1');

				redirectTo($filename, array('page' => $page, 's' => $s));

			} else {
				ask_yesno('admin_node_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['name']);
			}
		}

	} elseif ($action == 'add') {

		if (isset($_POST['send'])
			&& $_POST['send'] == 'send'
		) {

			$name = $_POST['name'];
			$image = $_POST['image'];
			$tag = $_POST['tag'];

			$result_checkfordouble_stmt = Database::prepare("
				SELECT `id` FROM `" . TABLE_NODES . "`
				WHERE `name` = :name"
			);
			$result_checkfordouble = Database::pexecute_first($result_checkfordouble_stmt, array('name' => $name));

			if ($result_checkfordouble['id'] != '') {
				standard_error('nodeexists');
			} else {
				$ins_stmt = Database::prepare("
					INSERT INTO `" . TABLE_NODES . "`
					SET
						`name` = :name, `image_name` = :image, `image_tag` = :tag;
				");
				$ins_data = array(
					'name' => $name,
					'image' => $image,
					'tag' => $tag
				);
				Database::pexecute($ins_stmt, $ins_data);

				$log->logAction(ADM_ACTION, LOG_WARNING, "added Node '" . $name . ":" . $image . "'");
				inserttask('1');
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}

		} else {

			$node_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/nodes/formfield.node_add.php';
			$node_add_form = htmlform::genHTMLForm($node_add_data);

			$title = $node_add_data['nodes_add']['title'];
			$image = $node_add_data['nodes_add']['image'];

			eval("echo \"" . getTemplate("nodes/node_add") . "\";");
		}

	} elseif ($action == 'edit'
		&& $id != 0
	) {
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_NODES . "` WHERE `id` = :id"
		);
		$result = Database::pexecute_first($result_stmt, array('id' => $id));

		$ipsandports = array();
		$usedips = array();

		$stmt = Database::query(
			"SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` ORDER BY `ip`, `port` ASC");

		Database::pexecute($stmt);
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$ipsandports[] = array('label' => $row['ip'] . ':' . $row['port'] . '<br />', 'value' => $row['id']);
		}

		$stmt = Database::prepare(
			"SELECT `id_ipandport` FROM `" . TABLE_NODETOIP . "` WHERE `id_node` = :id");

		Database::pexecute($stmt, array('id'=>$id));
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$usedips[] = $row['id_ipandport'];
		}

		if (isset($_POST['send'])
			&& $_POST['send'] == 'send'
		) {
			$name = $_POST['name'];
			$image = $_POST['image'];
			$tag = $_POST['tag'];

			$selectedips = array_key_exists('ipandport', $_POST)?$_POST['ipandport']:array();

			// delete every IPPORT in $usedips which is not in $selectedips
			$stmt = Database::prepare("DELETE FROM " . TABLE_NODETOIP . " WHERE `id_node` = :id_node AND `id_ipandport` = :del_id");
			foreach(array_diff($usedips, $selectedips) as $del_id) {
				Database::pexecute($stmt, array('id_node'=>$id,'del_id'=>$del_id));
			}

			// add every IPPORT in $selectedips which is not in $usedips
			$stmt = Database::prepare("INSERT INTO " . TABLE_NODETOIP . " SET `id_node`= :id_node, `id_ipandport`= :id_ipandport");
			foreach(array_diff($selectedips, $usedips) as $id_ipandport) {
					Database::pexecute($stmt, array('id_node'=>$id,'id_ipandport'=>$id_ipandport));
			}

			$result_checkfordouble_stmt = Database::prepare("
					SELECT `id` FROM `" . TABLE_NODES . "`
					WHERE `name` = :name AND `id` != :id"
			);
			$result_checkfordouble = Database::pexecute_first($result_checkfordouble_stmt, array('id' => $id, 'name' => $name));
			if($result_checkfordouble['id'] != '') {
				standard_error('nodeexists');
			} else {
				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_NODES . "`
					SET
						`name` = :name, `image_name` = :image, `image_tag` = :tag
					WHERE `id` = :id;
				");
				$upd_data = array(
					'name' => $name,
					'image' => $image,
					'tag' => $tag,
					'id' => $id
				);
				Database::pexecute($upd_stmt, $upd_data);

				$log->logAction(ADM_ACTION, LOG_WARNING, "changed Node '" . $result['name'] . ":" . $result['image_name'] . "' to '" . $name . ":" . $image . "'");
				inserttask('1');

				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
		} else {

			$result = htmlentities_array($result);

			$node_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/nodes/formfield.node_edit.php';
			$node_edit_form = htmlform::genHTMLForm($node_edit_data);

			$title = $node_edit_data['node_edit']['title'];
			$image = $node_edit_data['node_edit']['image'];

			eval("echo \"" . getTemplate("nodes/node_edit") . "\";");
		}
	}
}
