<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;
use Froxlor\Annotations\NaturalKey;

/**
 * Database
 *
 * @ORM\Table(name="panel_databases", indexes={@ORM\Index(name="customerid", columns={"customerid"})})
 * @ORM\Entity
 * @NaturalKey(columns={"databasename"})
 */
class Database extends ModelBasepanel
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
     * @ORM\Column(name="databasename", type="string", length=255, nullable=false)
     */
    public $databasename = '';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    public $description = '';

    /**
     *
     * Server on which this db resides. Corresponds to $sql_root[x] in
     *
     * @var integer
     *
     * @ORM\Column(name="dbserver", type="integer", nullable=false)
     */
    public $dbserver = '0';

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
