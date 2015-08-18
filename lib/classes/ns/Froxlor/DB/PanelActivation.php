<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * PanelActivation
 *
 * @ORM\Table(name="panel_activation")
 * @ORM\Entity
 */
class PanelActivation extends ModelBase
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
     * @var integer
     *
     * @ORM\Column(name="userid", type="integer", nullable=false)
     */
    public $userid = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="admin", type="boolean", nullable=false)
     */
    public $admin = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="creation", type="integer", nullable=false)
     */
    public $creation = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="activationcode", type="string", length=50, nullable=true)
     */
    public $activationcode;


}
