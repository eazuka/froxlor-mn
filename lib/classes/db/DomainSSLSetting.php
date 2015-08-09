<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * SSL setting for a Domain
 *
 * @ORM\Table(name="domain_ssl_settings", indexes={@ORM\Index(name="fk_domain", columns={"domainid"})})
 * @ORM\Entity
 */
class DomainSSLSetting extends ModelBase
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
     * @ORM\Column(name="ssl_cert_file", type="text", length=16777215, nullable=false)
     */
    public $sslCertFile;

    /**
     * @var string
     *
     * @ORM\Column(name="ssl_key_file", type="text", length=16777215, nullable=false)
     */
    public $sslKeyFile;

    /**
     * @var string
     *
     * @ORM\Column(name="ssl_ca_file", type="text", length=16777215, nullable=false)
     */
    public $sslCAFile;

    /**
     * @var string
     *
     * @ORM\Column(name="ssl_cert_chainfile", type="text", length=16777215, nullable=false)
     */
    public $sslCertChainfile;

    /**
     * @var \Domain
     *
     * @ORM\ManyToOne(targetEntity="Domain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="domainid", referencedColumnName="id")
     * })
     */
    public $domain;


}
