<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Formfields
 *
 */


return array(
	'node_edit' => array(
		'title' => $lng['admin']['nodes']['edit'],
		'image' => 'icons/ipsports_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['nodes']['node'],
				'image' => 'icons/ipsports_add.png',
				'fields' => array(
					'name' => array(
						'label' => $lng['admin']['nodes']['name'],
						'type' => 'text',
						'value' => $result['name']
					),
					'image' => array(
						'label' => $lng['admin']['nodes']['image'],
						'type' => 'text',
						'value' => $result['image_name'],
						'size' => 5
					),
					'tag' => array(
						'label' => $lng['admin']['nodes']['tag'],
						'type' => 'text',
						'value' => $result['image_tag'],
						'size' => 5
					)
				)
			),
			'section_b' => array(
				'title' => 'IPs/Ports',
				'image' => 'todo',
				'fields' => array(
					'ipandport' => array(
						'label' => $lng['admin']['nodes']['ipandport_multi']['title'],
						'type' => 'checkbox',
						'values' => $ipsandports,
						'value' => $usedips,
						'is_array' => 1,
						'mandatory' => true
					)
				)
			)
		)
	)
);