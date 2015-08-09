<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * HTAccess
 *
 * @ORM\Table(name="panel_htaccess", indexes={@ORM\Index(name="fk_customer", columns={"customerid"})})
 * @ORM\Entity
 */
class HTAccess extends ModelBase
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
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    public $path = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="options_indexes", type="boolean", nullable=false)
     */
    public $optionsIndexes = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="error404path", type="string", length=255, nullable=false)
     */
    public $error404path = '';

    /**
     * @var string
     *
     * @ORM\Column(name="error403path", type="string", length=255, nullable=false)
     */
    public $error403path = '';

    /**
     * @var string
     *
     * @ORM\Column(name="error500path", type="string", length=255, nullable=false)
     */
    public $error500path = '';

    /**
     * @var string
     *
     * @ORM\Column(name="error401path", type="string", length=255, nullable=false)
     */
    public $error401path = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="options_cgi", type="boolean", nullable=false)
     */
    public $optionsCgi = '0';

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
