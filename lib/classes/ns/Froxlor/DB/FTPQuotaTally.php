<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * FTPQuotaTally
 *
 * @ORM\Table(name="ftp_quotatallies")
 * @ORM\Entity
 */
class FTPQuotaTally extends ModelBase
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=30, nullable=false)
     * @ORM\Id
     */
    public $name;

    /**
     * @var string
     *
     * @ORM\Column(name="quota_type", type="string", nullable=false)
     * @ORM\Id
     */
    public $quotaType;

    /**
     * @var float
     *
     * @ORM\Column(name="bytes_in_used", type="float", precision=10, scale=0, nullable=false)
     */
    public $bytesInUsed;

    /**
     * @var float
     *
     * @ORM\Column(name="bytes_out_used", type="float", precision=10, scale=0, nullable=false)
     */
    public $bytesOutUsed;

    /**
     * @var float
     *
     * @ORM\Column(name="bytes_xfer_used", type="float", precision=10, scale=0, nullable=false)
     */
    public $bytesXferUsed;

    /**
     * @var integer
     *
     * @ORM\Column(name="files_in_used", type="integer", nullable=false)
     */
    public $filesInUsed;

    /**
     * @var integer
     *
     * @ORM\Column(name="files_out_used", type="integer", nullable=false)
     */
    public $filesOutUsed;

    /**
     * @var integer
     *
     * @ORM\Column(name="files_xfer_used", type="integer", nullable=false)
     */
    public $filesXferUsed;


}
