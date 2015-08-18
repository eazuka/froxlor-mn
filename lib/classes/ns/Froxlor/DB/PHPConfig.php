<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHPConfig
 *
 * @ORM\Table(name="panel_phpconfigs")
 * @ORM\Entity
 */
class PHPConfig extends ModelBase
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
     * @ORM\Column(name="description", type="string", length=50, nullable=false)
     */
    public $description;

    /**
     * @var string
     *
     * @ORM\Column(name="binary", type="string", length=255, nullable=false)
     */
    public $binary;

    /**
     * @var string
     *
     * @ORM\Column(name="file_extensions", type="string", length=255, nullable=false)
     */
    public $fileExtensions;

    /**
     * @var integer
     *
     * @ORM\Column(name="mod_fcgid_starter", type="integer", nullable=false)
     */
    public $modFcgidStarter = '-1';

    /**
     * @var integer
     *
     * @ORM\Column(name="mod_fcgid_maxrequests", type="integer", nullable=false)
     */
    public $modFcgidMaxrequests = '-1';

    /**
     * @var string
     *
     * @ORM\Column(name="mod_fcgid_umask", type="string", length=15, nullable=false)
     */
    public $modFcgidUmask = '022';

    /**
     * @var boolean
     *
     * @ORM\Column(name="fpm_slowlog", type="boolean", nullable=false)
     */
    public $fpmSlowlog = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="fpm_reqterm", type="string", length=15, nullable=false)
     */
    public $fpmReqterm = '60s';

    /**
     * @var string
     *
     * @ORM\Column(name="fpm_reqslow", type="string", length=15, nullable=false)
     */
    public $fpmReqslow = '5s';

    /**
     * @var string
     *
     * @ORM\Column(name="phpsettings", type="text", length=65535, nullable=false)
     */
    public $phpsettings;


}
