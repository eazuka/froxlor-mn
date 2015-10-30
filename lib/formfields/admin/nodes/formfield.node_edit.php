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
					),
					'is_default' => array(
						'label' => $lng['admin']['nodes']['default']['title'],
						'desc' => $lng['admin']['nodes']['default']['description'],
						'type' => 'checkbox',
						'value' => $result['is_default'],
						'values' => array(
							array ('label' => $lng['panel']['yes'], 'value' => '1')
						),
						'size' => 5
					)
				)
			),
			'section_b' => array(
				'title' => 'Domains',
				'image' => 'todo',
				'fields' => array(
					'domain' => array(
						'label' => $lng['admin']['nodes']['domain_multi']['title'],
						'type' => 'checkbox',
						'values' => $domains,
						'value' => $useddomains,
						'is_array' => 1,
						'mandatory' => true
					)
				)
			)
		)
	)
);