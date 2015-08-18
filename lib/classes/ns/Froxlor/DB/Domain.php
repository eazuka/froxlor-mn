<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;
use Froxlor\Annotations\NaturalKey;

/**
 * Domain
 *
 * @ORM\Table(name="panel_domains", indexes={@ORM\Index(name="domain", columns={"domain"}), @ORM\Index(name="adminid", columns={"adminid"}), @ORM\Index(name="fk_customer", columns={"customerid"}), @ORM\Index(name="fk_parent", columns={"parentdomainid"}), @ORM\Index(name="fk_alias", columns={"aliasdomain"}), @ORM\Index(name="fk_phpsetting", columns={"phpsettingid"})})
 * @ORM\Entity
 * @NaturalKey(columns={"domain"})
 */
class Domain extends ModelBase
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
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
	public $domain = '';

    /**
     * @var string
     *
     * @ORM\Column(name="documentroot", type="string", length=255, nullable=false)
     */
	public $documentroot = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="isbinddomain", type="boolean", nullable=false)
     */
	public $isbinddomain = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="isemaildomain", type="boolean", nullable=false)
     */
	public $isemaildomain = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="email_only", type="boolean", nullable=false)
     */
	public $emailOnly = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="iswildcarddomain", type="boolean", nullable=false)
     */
	public $iswildcarddomain = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="subcanemaildomain", type="boolean", nullable=false)
     */
	public $subcanemaildomain = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="caneditdomain", type="boolean", nullable=false)
     */
	public $caneditdomain = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="zonefile", type="string", length=255, nullable=false)
     */
	public $zonefile = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="dkim", type="boolean", nullable=false)
     */
	public $dkim = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="dkim_id", type="integer", nullable=false)
     */
	public $dkimId;

    /**
     * @var string
     *
     * @ORM\Column(name="dkim_privkey", type="text", length=65535, nullable=true)
     */
	public $dkimPrivkey;

    /**
     * @var string
     *
     * @ORM\Column(name="dkim_pubkey", type="text", length=65535, nullable=true)
     */
	public $dkimPubkey;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wwwserveralias", type="boolean", nullable=false)
     */
	public $wwwserveralias = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="openbasedir", type="boolean", nullable=false)
     */
	public $openbasedir = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="openbasedir_path", type="boolean", nullable=false)
     */
	public $openbasedirPath = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="speciallogfile", type="boolean", nullable=false)
     */
	public $speciallogfile = '0';


    /**
     * @var boolean
     *
     * @ORM\Column(name="ssl_redirect", type="boolean", nullable=false)
     */
	public $sslRedirect = '0';


    /**
     * @var string
     *
     * @ORM\Column(name="specialsettings", type="text", length=65535, nullable=true)
     */
	public $specialsettings;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deactivated", type="boolean", nullable=false)
     */
	public $deactivated = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="bindserial", type="string", length=10, nullable=false)
     */
	public $bindserial = '2000010100';

    /**
     * @var integer
     *
     * @ORM\Column(name="add_date", type="integer", nullable=false)
     */
	public $addDate = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="date", nullable=false)
     */
	public $registrationDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="mod_fcgid_starter", type="integer", nullable=true)
     */
	public $modFcgidStarter = '-1';

    /**
     * @var integer
     *
     * @ORM\Column(name="mod_fcgid_maxrequests", type="integer", nullable=true)
     */
	public $modFcgidMaxrequests = '-1';

    /**
     *
     * Parent domain, if the domain is a main domain, but still a subdomain to
     * another domain.
     *
     * This is effectively true for every subdomain created through admin_domains.php
     * and goes back to https://redmine.froxlor.org/issues/329
     *
     * @var Domain
     *
     * @ORM\ManyToOne(targetEntity="Domain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ismainbutsubto", referencedColumnName="id")
     * })
     */
	public $parentForMainDomain;

    /**
     * @var \Admin
     *
     * @ORM\ManyToOne(targetEntity="Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adminid", referencedColumnName="adminid")
     * })
     */
	public $admin;

    /**
     * @var \Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customerid", referencedColumnName="customerid")
     * })
     */
	public $customer;

    /**
     * Points to the parent domain if this domain is a subdomain created by
     * the customer (via customer_domains.php).
     *
     * @var \Domain
     *
     * @ORM\ManyToOne(targetEntity="Domain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parentdomainid", referencedColumnName="id")
     * })
     */
	public $parentDomain;

    /**
     *
     * If this domain is an alias domain for another domain, this will point
     * to the aliased domain.
     *
     * @var \Domain
     *
     * @ORM\ManyToOne(targetEntity="Domain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aliasdomain", referencedColumnName="id")
     * })
     */
	public $aliasFor;

    /**
     * @var \PHPConfig
     *
     * @ORM\ManyToOne(targetEntity="PHPConfig")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="phpsettingid", referencedColumnName="id")
     * })
     */
	public $phpConfig;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="RedirectCode", mappedBy="did")
     */
	public $redirectCodes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="IPAndPort", inversedBy="idDomain")
     * @ORM\JoinTable(name="panel_domaintoip",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_domain", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_ipandports", referencedColumnName="id")
     *   }
     * )
     */
	public $ipAndPorts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->redirectCodes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ipAndports = new \Doctrine\Common\Collections\ArrayCollection();
    }

	public static function getNaturalKeyMapping() {
		return array( 'adminid' => array('admin', 'loginname'),
					  'customerid' => array('customer', 'loginname'),
					  'parentdomainid' => array('parentDomain', 'domain'),
		              'aliasdomain' => array('aliasFor', 'domain'),
					  'ismainbutsubto' => array('parentForMainDomain', 'domain'));
	}

}
