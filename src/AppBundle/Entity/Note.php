<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 24/07/17
 * Time: 00:51
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="note", indexes={@ORM\Index(name="FK_773DE69D4D42DB17D", columns={"client_id"}), @ORM\Index(name="FK_773DE69D4D42DB18D", columns={"reservation_id"})})
 * @ORM\Entity
 */
class Note
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Client
     *
     * @ORM\OneToOne(targetEntity="Client", inversedBy="note")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $client;

    /**
     * @var Reservation
     *
     * @ORM\OneToOne(targetEntity="Reservation", inversedBy="note")
     * @ORM\JoinColumn(name="reservation_id", referencedColumnName="id")
     */
    protected $reservation;

    /**
     * @var integer
     *
     * @ORM\Column(name="car_note", type="integer", nullable=true)
     */
    protected $carNote;

    /**
     * @var integer
     *
     * @ORM\Column(name="service_note", type="integer", nullable=true)
     */
    protected $serviceNote;

    /**
     * @var string
     *
     * @ORM\Column(name="car_comment", type="string", nullable=true)
     */
    protected $carComment;

    /**
     * @var string
     *
     * @ORM\Column(name="service_comment", type="string", nullable=true)
     */
    protected $serviceComment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

}