<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Setting
 *
 * @ORM\Table(name="panel_settings")
 * @ORM\Entity
 */
class Setting extends ModelBase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="settingid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="settinggroup", type="string", length=255, nullable=false)
     */
    public $settinggroup = '';

    /**
     * @var string
     *
     * @ORM\Column(name="varname", type="string", length=255, nullable=false)
     */
    public $varname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text", length=65535, nullable=false)
     */
    public $value;


}
