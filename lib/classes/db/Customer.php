<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="panel_customers", uniqueConstraints={@ORM\UniqueConstraint(name="loginname", columns={"loginname"})}, indexes={@ORM\Index(name="adminid", columns={"adminid"})})
 * @ORM\Entity
 */
class Customer extends ModelBase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="customerid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="loginname", type="string", length=50, nullable=false)
     */
    public $loginname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    public $password = '';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    public $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    public $firstname = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="gender", type="integer", nullable=false)
     */
	public $gender = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=false)
     */
	public $company = '';

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=false)
     */
	public $street = '';

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=255, nullable=false)
     */
	public $zipcode = '';

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
	public $city = '';

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=false)
     */
	public $phone = '';

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=false)
     */
	public $fax = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
	public $email = '';

    /**
     * @var string
     *
     * @ORM\Column(name="customernumber", type="string", length=255, nullable=false)
     */
	public $customernumber = '';

    /**
     * @var string
     *
     * @ORM\Column(name="def_language", type="string", length=255, nullable=false)
     */
	public $defLanguage = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="diskspace", type="bigint", nullable=false)
     */
	public $diskspace = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="diskspace_used", type="bigint", nullable=false)
     */
	public $diskspaceUsed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="mysqls", type="integer", nullable=false)
     */
	public $mysqls = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="mysqls_used", type="integer", nullable=false)
     */
	public $mysqlsUsed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="emails", type="integer", nullable=false)
     */
	public $emails = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="emails_used", type="integer", nullable=false)
     */
	public $emailsUsed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="email_accounts", type="integer", nullable=false)
     */
	public $emailAccounts = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="email_accounts_used", type="integer", nullable=false)
     */
	public $emailAccountsUsed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="email_forwarders", type="integer", nullable=false)
     */
	public $emailForwarders = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="email_forwarders_used", type="integer", nullable=false)
     */
	public $emailForwardersUsed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="email_quota", type="bigint", nullable=false)
     */
	public $emailQuota = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="email_quota_used", type="bigint", nullable=false)
     */
	public $emailQuotaUsed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="ftps", type="integer", nullable=false)
     */
	public $ftps = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="ftps_used", type="integer", nullable=false)
     */
	public $ftpsUsed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="tickets", type="integer", nullable=false)
     */
	public $tickets = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="tickets_used", type="integer", nullable=false)
     */
	public $ticketsUsed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="subdomains", type="integer", nullable=false)
     */
	public $subdomains = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="subdomains_used", type="integer", nullable=false)
     */
	public $subdomainsUsed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="traffic", type="bigint", nullable=false)
     */
	public $traffic = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="traffic_used", type="bigint", nullable=false)
     */
	public $trafficUsed = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="documentroot", type="string", length=255, nullable=false)
     */
	public $documentroot = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="standardsubdomain", type="integer", nullable=false)
     */
	public $standardsubdomain = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="guid", type="integer", nullable=false)
     */
	public $guid = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="ftp_lastaccountnumber", type="integer", nullable=false)
     */
	public $ftpLastaccountnumber = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="mysql_lastaccountnumber", type="integer", nullable=false)
     */
	public $mysqlLastaccountnumber = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="deactivated", type="boolean", nullable=false)
     */
	public $deactivated = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="phpenabled", type="boolean", nullable=false)
     */
	public $phpenabled = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="lastlogin_succ", type="integer", nullable=false)
     */
	public $lastloginSucc = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="lastlogin_fail", type="integer", nullable=false)
     */
	public $lastloginFail = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="loginfail_count", type="integer", nullable=false)
     */
	public $loginfailCount = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="reportsent", type="boolean", nullable=false)
     */
	public $reportsent = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="pop3", type="boolean", nullable=false)
     */
	public $pop3 = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="imap", type="boolean", nullable=false)
     */
	public $imap = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="perlenabled", type="boolean", nullable=false)
     */
	public $perlenabled = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=255, nullable=false)
     */
	public $theme = 'Sparkle';

    /**
     * @var string
     *
     * @ORM\Column(name="custom_notes", type="text", length=65535, nullable=true)
     */
	public $customNotes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="custom_notes_show", type="boolean", nullable=false)
     */
	public $customNotesShow = '0';

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
	 * Bidirectional - One-To-Many (INVERSE SIDE)
	 *
	 * @ORM\OneToMany(targetEntity="Domain", mappedBy="customer")
	 */
	public $domains;


    public function getName() {
        return $this->name;
    }

    public function getUsername() {
        return $this->username;
    }
}
