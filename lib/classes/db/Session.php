<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table(name="panel_sessions", indexes={@ORM\Index(name="userid", columns={"userid"})})
 * @ORM\Entity
 */
class Session extends ModelBase
{
    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=32, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $hash = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="userid", type="integer", nullable=false)
     */
    public $userid = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ipaddress", type="string", length=255, nullable=false)
     */
    public $ipaddress = '';

    /**
     * @var string
     *
     * @ORM\Column(name="useragent", type="string", length=255, nullable=false)
     */
    public $useragent = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="lastactivity", type="integer", nullable=false)
     */
    public $lastactivity = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="lastpaging", type="string", length=255, nullable=false)
     */
    public $lastpaging = '';

    /**
     * @var string
     *
     * @ORM\Column(name="formtoken", type="string", length=32, nullable=false)
     */
    public $formtoken = '';

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=64, nullable=false)
     */
    public $language = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="adminsession", type="boolean", nullable=false)
     */
    public $adminsession = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=255, nullable=false)
     */
    public $theme = '';


}
