<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * HTPasswd
 *
 * @ORM\Table(name="panel_htpasswds", indexes={@ORM\Index(name="fk_customerid", columns={"customerid"})})
 * @ORM\Entity
 */
class HTPasswd extends ModelBase
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
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    public $username = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    public $password = '';

    /**
     * @var string
     *
     * @ORM\Column(name="authname", type="string", length=255, nullable=false)
     */
    public $authname = 'Restricted Area';

    /**
     * @var \Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customerid", referencedColumnName="customerid")
     * })
     */
    public $customerid;


}
