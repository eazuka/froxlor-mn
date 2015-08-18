<?php
namespace Froxlor\DB;


use Doctrine\ORM\Mapping as ORM;

/**
 * AdminDiskspace
 *
 * collects diskspace usage per admin and day
 *
 * @ORM\Entity
 * @ORM\Table(name="panel_diskspace_admins", indexes={@ORM\Index(name="fk_admin", columns={"adminid"})})
 */
class AdminDiskspace extends ModelBase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @ORM\Column(name="webspace", type="bigint", nullable=false)
     */
    public $webspace = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="mail", type="bigint", nullable=false)
     */
    public $mail = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="mysql", type="bigint", nullable=false)
     */
    public $mysql = '0';

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
