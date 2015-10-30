<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHPConfig
 *
 * @ORM\Table(name="panel_nodes")
 * @ORM\Entity
 */
class Node extends ModelBase
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
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    public $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="string", length=128, nullable=false)
     */
    public $image_name;

    /**
     * @var string
     *
     * @ORM\Column(name="image_tag", type="string", length=128, nullable=false)
     */
    public $image_tag;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_default", type="boolean", nullable=false)
	 */
	public $isDefault = '0';

	/**
	 * @var \Doctrine\Common\Collections\Collection
	 *
	 * @ORM\ManyToMany(targetEntity="Domain", inversedBy="idNode")
	 * @ORM\JoinTable(name="panel_nodetodomain",
	 *   joinColumns={
	 *     @ORM\JoinColumn(name="id_node", referencedColumnName="id")
	 *   },
	 *   inverseJoinColumns={
	 *     @ORM\JoinColumn(name="id_domain", referencedColumnName="id")
	 *   }
	 * )
	 */
	public $domains;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->domains = new \Doctrine\Common\Collections\ArrayCollection();
	}
}
