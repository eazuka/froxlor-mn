<?php
/**
 * Class ModelBase
 *
 * base class for all our DB models, provides features like import/export, ...
 *
 */

namespace Froxlor\DB;

use Doctrine\Common\Annotations\AnnotationReader;

abstract class ModelBase
{
	/**
	 * return the database row for this instance as PHP array.
	 *
	 * taken from http://stackoverflow.com/questions/13507300/
	 *
	 * @param $em                   Doctrine\ORM\EntityManager instance
	 * @param $use_natural_keys     whether to use natural keys instead
	 * @return array
	 */
	public function toArray($em, $use_natural_keys=false) {
		$uow = $em->getUnitOfWork();
		$entityPersister = $uow->getEntityPersister(get_class($this));
		$classMetadata = $entityPersister->getClassMetadata();

		$originalData = $uow->getOriginalEntityData($this);

		$annotationReader = new AnnotationReader();

		$result = array();
		foreach ($originalData as $field => $value) {
			if (isset($classMetadata->associationMappings[$field])) {
				$assoc = $classMetadata->associationMappings[$field];

				// Only owning side of x-1 associations can have a FK column.
				if ( ! $assoc['isOwningSide'] || ! ($assoc['type'] & \Doctrine\ORM\Mapping\ClassMetadata::TO_ONE)) {
					continue;
				}

				if ($value !== null) {
					$newValId = $uow->getEntityIdentifier($value);
				}

				$targetClass = $em->getClassMetadata($assoc['targetEntity']);

				foreach ($assoc['joinColumns'] as $joinColumn) {
					$sourceColumn = $joinColumn['name'];
					$targetColumn = $joinColumn['referencedColumnName'];

					if ($value === null) {
						$result[$sourceColumn] = null;
					} else if ($targetClass->containsForeignIdentifier) {
						$result[$sourceColumn] = $newValId[$targetClass->getFieldForColumn($targetColumn)];
					} else {
						if ($use_natural_keys) {
							$ann = $annotationReader->getClassAnnotation($targetClass->reflClass, 'Froxlor\Annotations\NaturalKey');
							if ($ann != null) {
								$nk = array();
								foreach($ann->columns as $col) {
									$nk[$col] = $value->$col;
								}
								$result[$sourceColumn] = $nk;
							} else {
								$result[$sourceColumn] = $newValId[$targetClass->fieldNames[$targetColumn]];
							}
						} else {
							$result[$sourceColumn] = $newValId[$targetClass->fieldNames[$targetColumn]];
						}
					}
				}
			} elseif (isset($classMetadata->columnNames[$field])) {
				$columnName = $classMetadata->columnNames[$field];
				$result[$columnName] = $value;
			}
		}

		// replace with natural keys, if required
		if ($use_natural_keys) {
			/*
			$mappings = $this->getNaturalKeyMapping();
			foreach($result as $name=>$value) {
				if (array_key_exists($name, $mappings)) {
					$mapping = $mappings[$name];
					$attr = $this->$mapping[0];
					if ($attr) {
						$result[$name] = $attr->$mapping[1];
					}
				}
			}
			*/
		}

		return $result;
	}

	/**
	 * Create an instance from serialized data. This
	 *
	 * @param $data db data, as retrieved from toArray()
	 */
	public static function fromArray($data) {
		// todo
	}
}