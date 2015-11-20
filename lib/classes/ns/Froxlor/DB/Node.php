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
	 * Domains which are directly assigned to this Node. Note that this
	 * does not include domains whose Master is assigned to this node,
	 * or unassigned domains handled by the default node.
	 *
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

	/**
	 * Check whether this node handles a certain IP. This is true for all IPs
	 * assigned to domains running on this node.
	 *
	 * This function is used for generating Listen statements (e.g. Apache)
	 *
	 * @param $entityManager    instance of EntityManager
	 * @param $ip_id            id of ip to check
	 * @return true if this node handles this IP, false if not
	 */
	public function handlesIP(\Doctrine\ORM\EntityManager $entityManager, $ip_id) {
		// TODO: this could be more efficient...
		// TODO: do we need this at all?
		$ipport = $entityManager->find('Froxlor\DB\IPAndPort', $ip_id);
		if ($ipport != null) {
			foreach($ipport->domains as $domain) {
				if ($this->handlesDomain($entityManager, $domain->id)) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Check whether this node handles a certain domain. This is true for all
	 * domains assigned to this node, and also for domains which do not have
	 * a node assigned, if this node is the default node.
	 *
	 * This function is used for generating vhost statements (e.g. Apache)
	 *
	 * @param $entityManager instance of EntityManager
	 * @param $domain_id     id of domain to check
	 * @return               true if this node handles this IP, false if not
	 */
	public function handlesDomain(\Doctrine\ORM\EntityManager $entityManager, $domain_id) {
		$domain = $entityManager->find('Froxlor\DB\Domain', $domain_id);
		if ($domain != null) {
			foreach($domain->getNodes($entityManager) as $node) {
				if ($node->id == $this->id) {
					return true;
				}
			}
		}
		return false;
	}
}
