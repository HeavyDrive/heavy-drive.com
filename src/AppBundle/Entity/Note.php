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


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set carNote
     *
     * @param integer $carNote
     *
     * @return Note
     */
    public function setCarNote($carNote)
    {
        $this->carNote = $carNote;

        return $this;
    }

    /**
     * Get carNote
     *
     * @return integer
     */
    public function getCarNote()
    {
        return $this->carNote;
    }

    /**
     * Set serviceNote
     *
     * @param integer $serviceNote
     *
     * @return Note
     */
    public function setServiceNote($serviceNote)
    {
        $this->serviceNote = $serviceNote;

        return $this;
    }

    /**
     * Get serviceNote
     *
     * @return integer
     */
    public function getServiceNote()
    {
        return $this->serviceNote;
    }

    /**
     * Set carComment
     *
     * @param string $carComment
     *
     * @return Note
     */
    public function setCarComment($carComment)
    {
        $this->carComment = $carComment;

        return $this;
    }

    /**
     * Get carComment
     *
     * @return string
     */
    public function getCarComment()
    {
        return $this->carComment;
    }

    /**
     * Set serviceComment
     *
     * @param string $serviceComment
     *
     * @return Note
     */
    public function setServiceComment($serviceComment)
    {
        $this->serviceComment = $serviceComment;

        return $this;
    }

    /**
     * Get serviceComment
     *
     * @return string
     */
    public function getServiceComment()
    {
        return $this->serviceComment;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Note
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Note
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Note
     */
    public function setClient(\AppBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set reservation
     *
     * @param \AppBundle\Entity\Reservation $reservation
     *
     * @return Note
     */
    public function setReservation(\AppBundle\Entity\Reservation $reservation = null)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     *
     * @return \AppBundle\Entity\Reservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }
}
