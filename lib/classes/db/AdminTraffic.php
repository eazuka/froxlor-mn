<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * keep admin's traffic, per day
 *
 * @ORM\Table(name="panel_traffic_admins", indexes={@ORM\Index(name="fk_admin", columns={"adminid"})})
 * @ORM\Entity
 */
class AdminTraffic extends ModelBase
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
     * @var \Admin
     *
     * @ORM\ManyToOne(targetEntity="Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adminid", referencedColumnName="adminid")
     * })
     */
    public $admin;


}
