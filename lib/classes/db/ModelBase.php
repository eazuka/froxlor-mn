<?php

/**
 * Class ModelBase
 *
 * base class for all our DB models, provides features like import/export, ...
 *
 */

abstract class ModelBase
{
	public function toArray() {
		return array('foo'=>'bar');
	}

	public static function fromArray($data) {

	}
}