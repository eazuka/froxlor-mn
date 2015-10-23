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
	'nodes_add' => array(
		'title' => $lng['admin']['nodes']['add'],
		'image' => 'icons/ipsports_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['nodes']['node'],
				'image' => 'icons/ipsports_add.png',
				'fields' => array(
					'name' => array(
						'label' => $lng['admin']['nodes']['name'],
						'type' => 'text'
					),
					'image' => array(
						'label' => $lng['admin']['nodes']['image'],
						'type' => 'text',
						'size' => 5
					),
					'tag' => array(
						'label' => $lng['admin']['nodes']['tag'],
						'type' => 'text',
						'size' => 5
					)
				)
			)
		)
	)
);
