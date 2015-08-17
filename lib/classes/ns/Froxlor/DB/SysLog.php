<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * SysLog
 *
 * @ORM\Table(name="panel_syslog")
 * @ORM\Entity
 */
class SysLog extends ModelBase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="logid", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="action", type="integer", nullable=false)
     */
    public $action = '10';

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    public $type = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="date", type="integer", nullable=false)
     */
    public $date;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=50, nullable=false)
     */
    public $user;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", length=65535, nullable=false)
     */
    public $text;


}
