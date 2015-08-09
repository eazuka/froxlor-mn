<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * FtpGroup
 *
 * @ORM\Table(name="ftp_groups", uniqueConstraints={@ORM\UniqueConstraint(name="groupname", columns={"groupname"})}, indexes={@ORM\Index(name="fk_customer", columns={"customerid"})})
 * @ORM\Entity
 */
class FTPGroup extends ModelBase
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
     * @ORM\Column(name="groupname", type="string", length=60, nullable=false)
     */
    public $groupname = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="gid", type="integer", nullable=false)
     */
    public $gid = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="members", type="text", nullable=false)
     */
    public $members;

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
