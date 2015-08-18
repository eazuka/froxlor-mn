<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * FTPQuotaLimit
 *
 * @ORM\Table(name="ftp_quotalimits")
 * @ORM\Entity
 */
class FTPQuotaLimit extends ModelBase
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=30, nullable=false)
     * @ORM\Id
     */
    public $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="quota_type", type="string", nullable=false)
     * @ORM\Id
     */
    public $quotaType = 'user';

    /**
     * @var string
     *
     * @ORM\Column(name="per_session", type="string", nullable=false)
     */
    public $perSession = 'false';

    /**
     * @var string
     *
     * @ORM\Column(name="limit_type", type="string", nullable=false)
     */
    public $limitType = 'hard';

    /**
     * @var float
     *
     * @ORM\Column(name="bytes_in_avail", type="float", precision=10, scale=0, nullable=false)
     */
    public $bytesInAvail;

    /**
     * @var float
     *
     * @ORM\Column(name="bytes_out_avail", type="float", precision=10, scale=0, nullable=false)
     */
    public $bytesOutAvail;

    /**
     * @var float
     *
     * @ORM\Column(name="bytes_xfer_avail", type="float", precision=10, scale=0, nullable=false)
     */
    public $bytesXferAvail;

    /**
     * @var integer
     *
     * @ORM\Column(name="files_in_avail", type="integer", nullable=false)
     */
    public $filesInAvail;

    /**
     * @var integer
     *
     * @ORM\Column(name="files_out_avail", type="integer", nullable=false)
     */
    public $filesOutAvail;

    /**
     * @var integer
     *
     * @ORM\Column(name="files_xfer_avail", type="integer", nullable=false)
     */
    public $filesXferAvail;


}
