<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 *
 * @ORM\Table(name="panel_languages")
 * @ORM\Entity
 */
class Language extends ModelBase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=30, nullable=false)
     */
    public $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="iso", type="string", length=3, nullable=false)
     */
    public $iso = 'foo';

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=false)
     */
    public $file = '';


}
