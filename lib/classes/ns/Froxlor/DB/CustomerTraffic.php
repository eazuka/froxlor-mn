<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * Keeps customer's traffic, by day
 *
 * @ORM\Table(name="panel_traffic", indexes={@ORM\Index(name="fk_customer", columns={"customerid"})})
 * @ORM\Entity
 */
class CustomerTraffic extends ModelBase
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
     * @var integer
     *
     * @ORM\Column(name="year", type="integer", nullable=false)
     */
    public $year = '0000';

    /**
     * @var integer
     *
     * @ORM\Column(name="month", type="integer", nullable=false)
     */
    public $month = '00';

    /**
     * @var integer
     *
     * @ORM\Column(name="day", type="integer", nullable=false)
     */
    public $day = '00';

    /**
     * @var integer
     *
     * @ORM\Column(name="stamp", type="integer", nullable=false)
     */
    public $stamp = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="http", type="bigint", nullable=false)
     */
    public $http = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="ftp_up", type="bigint", nullable=false)
     */
    public $ftpUp = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="ftp_down", type="bigint", nullable=false)
     */
    public $ftpDown = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="mail", type="bigint", nullable=false)
     */
    public $mail = '0';

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
