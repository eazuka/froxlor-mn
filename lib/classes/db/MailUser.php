<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MailUsers
 *
 * @ORM\Table(name="mail_users", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})}, indexes={@ORM\Index(name="fk_customer", columns={"customerid"}), @ORM\Index(name="fk_domain", columns={"domainid"})})
 * @ORM\Entity
 */
class MailUser extends ModelBase
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    public $email = '';

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    public $username = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=128, nullable=false)
     */
    public $password = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password_enc", type="string", length=128, nullable=false)
     */
    public $passwordEnc = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="uid", type="integer", nullable=false)
     */
    public $uid = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="gid", type="integer", nullable=false)
     */
    public $gid = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="homedir", type="string", length=255, nullable=false)
     */
    public $homedir = '';

    /**
     * @var string
     *
     * @ORM\Column(name="maildir", type="string", length=255, nullable=false)
     */
    public $maildir = '';

    /**
     * @var string
     *
     * @ORM\Column(name="postfix", type="string", nullable=false)
     */
    public $postfix = 'Y';

    /**
     * @var integer
     *
     * @ORM\Column(name="quota", type="bigint", nullable=false)
     */
    public $quota = '0';

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
     * @var integer
     *
     * @ORM\Column(name="mboxsize", type="bigint", nullable=false)
     */
    public $mboxsize = '0';

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
     * @var \Domain
     *
     * @ORM\ManyToOne(targetEntity="Domain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="domainid", referencedColumnName="id")
     * })
     */
    public $domain;


}
