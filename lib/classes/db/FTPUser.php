<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * FtpUsers
 *
 * @ORM\Table(name="ftp_users", uniqueConstraints={@ORM\UniqueConstraint(name="username", columns={"username"})}, indexes={@ORM\Index(name="fk_customer", columns={"customerid"})})
 * @ORM\Entity
 */
class FTPUser extends ModelBase
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
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    public $username = '';

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
     * @ORM\Column(name="password", type="string", length=128, nullable=false)
     */
    public $password = '';

    /**
     * @var string
     *
     * @ORM\Column(name="homedir", type="string", length=255, nullable=false)
     */
    public $homedir = '';

    /**
     * @var string
     *
     * @ORM\Column(name="shell", type="string", length=255, nullable=false)
     */
    public $shell = '/bin/false';

    /**
     * @var string
     *
     * @ORM\Column(name="login_enabled", type="string", nullable=false)
     */
    public $loginEnabled = 'N';

    /**
     * @var integer
     *
     * @ORM\Column(name="login_count", type="integer", nullable=false)
     */
    public $loginCount = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=false)
     */
    public $lastLogin = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="up_count", type="integer", nullable=false)
     */
    public $upCount = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="up_bytes", type="bigint", nullable=false)
     */
    public $upBytes = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="down_count", type="integer", nullable=false)
     */
    public $downCount = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="down_bytes", type="bigint", nullable=false)
     */
    public $downBytes = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    public $description = '';

    /**
     * @var \Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customerid", referencedColumnName="customerid")
     * })
     */
    public $customer;


}
