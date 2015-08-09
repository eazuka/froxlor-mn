<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Template
 *
 * @ORM\Table(name="panel_templates", indexes={@ORM\Index(name="fk_admin", columns={"adminid"})})
 * @ORM\Entity
 */
class Template extends ModelBase
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
     * @ORM\Column(name="language", type="string", length=255, nullable=false)
     */
    public $language = '';

    /**
     * @var string
     *
     * @ORM\Column(name="templategroup", type="string", length=255, nullable=false)
     */
    public $templategroup = '';

    /**
     * @var string
     *
     * @ORM\Column(name="varname", type="string", length=255, nullable=false)
     */
    public $varname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text", nullable=false)
     */
    public $value;

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
