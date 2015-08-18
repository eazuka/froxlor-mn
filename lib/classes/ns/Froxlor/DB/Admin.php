<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;
use Froxlor\Annotations\NaturalKey;

/**
 * Admin
 *
 * @ORM\Table(name="panel_admins", uniqueConstraints={@ORM\UniqueConstraint(name="loginname", columns={"loginname"})})
 * @ORM\Entity
 * @NaturalKey(columns={"loginname"})
 */
class Admin extends ModelBase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="adminid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    public $email = '';

    /**
     * @var string
     *
     * @ORM\Column(name="def_language", type="string", length=255, nullable=false)
     */
    public $defLanguage = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="ip", type="boolean", nullable=false)
     */
    public $ip = '-1';

    /**
     *
     * maximum number of customers this admin may have; -1 = unlimited
     *
     * @var integer
     *
     * @ORM\Column(name="customers", type="integer", nullable=false)
     */
    public $customersMax = '0';

    /**
     * actual number of customers this admin has
     *
     * @var integer
     *
     * @ORM\Column(name="customers_used", type="integer", nullable=false)
     */
    public $customersUsed = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="customers_see_all", type="boolean", nullable=false)
     */
    public $customersSeeAll = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="domains", type="integer", nullable=false)
     */
    public $domainsMax = '0';

    /**
     *
     * maximum number of domains for this admin
     *
     * @var integer
     *
     * @ORM\Column(name="domains_used", type="integer", nullable=false)
     */
    public $domainsUsed = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="domains_see_all", type="boolean", nullable=false)
     */
    public $domainsSeeAll = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="caneditphpsettings", type="boolean", nullable=false)
     */
    public $caneditphpsettings = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="change_serversettings", type="boolean", nullable=false)
     */
    public $changeServersettings = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="diskspace", type="integer", nullable=false)
     */
    public $diskspaceMax = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="diskspace_used", type="integer", nullable=false)
     */
    public $diskspaceUsed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="mysqls", type="integer", nullable=false)
     */
    public $mysqlsMax = '0';

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
    public $emailsMax = '0';

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
    public $emailAccountsMax = '0';

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
    public $emailForwardersMax = '0';

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
    public $ftpsMax = '0';

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
    public $ticketsMax = '-1';

    /**
     * @var integer
     *
     * @ORM\Column(name="tickets_used", type="integer", nullable=false)
     */
    public $ticketsUsed = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="tickets_see_all", type="boolean", nullable=false)
     */
    public $ticketsSeeAll = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="subdomains", type="integer", nullable=false)
     */
    public $subdomainsMax = '0';

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
    public $trafficMax = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="traffic_used", type="bigint", nullable=false)
     */
    public $trafficUsed = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="deactivated", type="boolean", nullable=false)
     */
    public $deactivated = '0';

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
	 * Customers for this admin (reverse relation)
	 *
	 * @ORM\OneToMany(targetEntity="Customer", mappedBy="adminid")
	 */
	public $customers;

}
