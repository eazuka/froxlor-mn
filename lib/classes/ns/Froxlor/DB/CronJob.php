<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * CronJob
 *
 * represents a cron job
 *
 *
 * @ORM\Entity
 * @ORM\Table(name="cronjobs_run")
 */
class CronJob extends ModelBase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="module", type="string", length=250, nullable=false)
     */
    public $module;

    /**
     * @var string
     *
     * @ORM\Column(name="cronfile", type="string", length=250, nullable=false)
     */
    public $cronfile;

    /**
     * @var integer
     *
     * @ORM\Column(name="lastrun", type="integer", nullable=false)
     */
    public $lastrun = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="interval", type="string", length=100, nullable=false)
     */
    public $interval = '5 MINUTE';

    /**
     * @var boolean
     *
     * @ORM\Column(name="isactive", type="boolean", nullable=true)
     */
    public $isactive = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="desc_lng_key", type="string", length=100, nullable=false)
     */
    public $descLngKey = 'cron_unknown_desc';


}
