<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;
use Froxlor\Annotations\NaturalKey;

/**
 * IPAndPort
 *
 * @ORM\Table(name="panel_ipsandports")
 * @ORM\Entity
 * @NaturalKey(columns={"ip","port"})
 */
class IPAndPort extends ModelBase
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
     * @ORM\Column(name="ip", type="string", length=39, nullable=false)
     */
    public $ip = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="port", type="integer", nullable=false)
     */
    public $port = '80';

    /**
     * @var boolean
     *
     * @ORM\Column(name="listen_statement", type="boolean", nullable=false)
     */
    public $listenStatement = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="namevirtualhost_statement", type="boolean", nullable=false)
     */
    public $namevirtualhostStatement = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="vhostcontainer", type="boolean", nullable=false)
     */
    public $vhostcontainer = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="vhostcontainer_servername_statement", type="boolean", nullable=false)
     */
    public $vhostcontainerServernameStatement = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="specialsettings", type="text", length=65535, nullable=true)
     */
    public $specialsettings;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ssl", type="boolean", nullable=false)
     */
    public $ssl = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ssl_cert_file", type="string", length=255, nullable=false)
     */
    public $sslCertFile;

    /**
     * @var string
     *
     * @ORM\Column(name="ssl_key_file", type="string", length=255, nullable=false)
     */
    public $sslKeyFile;

    /**
     * @var string
     *
     * @ORM\Column(name="ssl_ca_file", type="string", length=255, nullable=false)
     */
    public $sslCAFile;

    /**
     * @var string
     *
     * @ORM\Column(name="default_vhostconf_domain", type="text", length=65535, nullable=true)
     */
    public $defaultVhostConfDomain;

    /**
     * @var string
     *
     * @ORM\Column(name="ssl_cert_chainfile", type="string", length=255, nullable=false)
     */
    public $sslCertChainfile;

    /**
     * @var string
     *
     * @ORM\Column(name="docroot", type="string", length=255, nullable=false)
     */
    public $docroot = '';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Domain", mappedBy="idIpandports")
     */
    public $domains;

	/**
     * Constructor
     */
    public function __construct()
    {
        $this->idDomain = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
