<?php
namespace Froxlor\DB;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="panel_tickets", indexes={@ORM\Index(name="fk_admin", columns={"adminid"}), @ORM\Index(name="fk_customer", columns={"customerid"})})
 * @ORM\Entity
 */
class Ticket extends ModelBase
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
     * @var TicketCategory
     *
     * @ORM\ManyToOne(targetEntity="TicketCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id")
     * })
     */
    public $category;

    /**
     * @var string
     *
     * @ORM\Column(name="priority", type="string", nullable=false)
     */
    public $priority = '3';

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=70, nullable=false)
     */
    public $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=65535, nullable=false)
     */
    public $message;

    /**
     * @var integer
     *
     * @ORM\Column(name="dt", type="integer", nullable=false)
     */
    public $dt;

    /**
     * @var integer
     *
     * @ORM\Column(name="lastchange", type="integer", nullable=false)
     */
    public $lastchange;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=39, nullable=false)
     */
    public $ip = '';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    public $status = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="lastreplier", type="string", nullable=false)
     */
    public $lastreplier = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="answerto", type="integer", nullable=false)
     */
    public $answerto;

    /**
     * @var string
     *
     * @ORM\Column(name="by", type="string", nullable=false)
     */
    public $by = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="archived", type="string", nullable=false)
     */
    public $archived = '0';

    /**
     * @var \Admin
     *
     * @ORM\ManyToOne(targetEntity="Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adminid", referencedColumnName="adminid")
     * })
     */
    public $admin;

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
	 * natural key mapping for ticket
	 * @return array
	 */
	public static function getNaturalKeyMapping() {
		return array(
			'adminid' => array('admin', 'loginname'),
			'customerid' => array('customer', 'loginname'),
			'category' => array('category', 'name')
		);
	}

}
