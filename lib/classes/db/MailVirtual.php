<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * MailVirtual
 *
 * @ORM\Table(name="mail_virtual", indexes={@ORM\Index(name="email", columns={"email"}), @ORM\Index(name="fk_customer", columns={"customerid"}), @ORM\Index(name="fk_domain", columns={"domainid"}), @ORM\Index(name="fk_account", columns={"popaccountid"})})
 * @ORM\Entity
 */
class MailVirtual extends ModelBase
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    public $email = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email_full", type="string", length=255, nullable=false)
     */
    public $emailFull = '';

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="text", length=65535, nullable=false)
     */
    public $destination;

    /**
     * @var boolean
     *
     * @ORM\Column(name="iscatchall", type="boolean", nullable=false)
     */
    public $iscatchall = '0';

    /**
     * @var \Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customerid", referencedColumnName="customerid")
     * })
     */
    public $customer;

    /**
     * @var \Domain
     *
     * @ORM\ManyToOne(targetEntity="Domain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="domainid", referencedColumnName="id")
     * })
     */
    public $domain;

    /**
     * @var \MailUsers
     *
     * @ORM\ManyToOne(targetEntity="MailUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="popaccountid", referencedColumnName="id")
     * })
     */
    public $mailuser;


}
