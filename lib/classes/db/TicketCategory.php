<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * TicketCategory
 *
 * @ORM\Table(name="panel_ticket_categories", indexes={@ORM\Index(name="fk_admin", columns={"adminid"})})
 * @ORM\Entity
 */
class TicketCategory extends ModelBase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60, nullable=false)
     */
    public $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="logicalorder", type="integer", nullable=false)
     */
    public $logicalorder = '1';

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
