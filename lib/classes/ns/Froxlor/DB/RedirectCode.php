<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * RedirectCode
 *
 * @ORM\Table(name="redirect_codes")
 * @ORM\Entity
 */
class RedirectCode extends ModelBase
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
     * @ORM\Column(name="code", type="string", length=3, nullable=false)
     */
    public $code;

    /**
     * @var string
     *
     * @ORM\Column(name="desc", type="string", length=200, nullable=false)
     */
    public $desc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    public $enabled = '1';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Domain", inversedBy="rid")
     * @ORM\JoinTable(name="domain_redirect_codes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="rid", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="did", referencedColumnName="id")
     *   }
     * )
     */
    public $did;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->did = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
