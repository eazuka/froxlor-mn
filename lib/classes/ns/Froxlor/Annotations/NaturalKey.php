<?php
namespace Froxlor\Annotations;

use Doctrine\ORM\Mapping\Annotation;

/**
 * NaturalKey - allow to designate a "natural" (alternative) key for an entity,
 * which can be used for import/export instead of the surrogate numeric id, which
 * is system-dependent
 *
 * @Annotation
 * @Target("CLASS")
 * @package Froxlor\Annotations
 */
class NaturalKey implements Annotation
{
	/** @var array<string> */
	public $columns;
}