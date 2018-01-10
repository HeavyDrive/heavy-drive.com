<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 30/08/17
 * Time: 19:19
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="booking_options")
 */
class BookingOptions
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */

    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=0, nullable=false)
     */
    protected $price;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_options", type="string", length=255, nullable=false)
     */
    protected $commentOptions;

    /**
     * Many Groups have Many Users.
     * @ORM\ManyToMany(targetEntity="Reservation", mappedBy="bookingOptions")
     */
    protected $reservations;
    
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
     * Set name
     *
     * @param string $name
     *
     * @return BookingOptions
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return BookingOptions
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set commentOptions
     *
     * @param string $commentOptions
     *
     * @return BookingOptions
     */
    public function setCommentOptions($commentOptions)
    {
        $this->commentOptions = $commentOptions;

        return $this;
    }

    /**
     * Get commentOptions
     *
     * @return string
     */
    public function getCommentOptions()
    {
        return $this->commentOptions;
    }

    /**
     * Add reservation
     *
     * @param \AppBundle\Entity\BookingOptions $reservation
     *
     * @return BookingOptions
     */
    public function addReservation(\AppBundle\Entity\BookingOptions $reservation)
    {
        $this->reservation[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \AppBundle\Entity\BookingOptions $reservation
     */
    public function removeReservation(\AppBundle\Entity\BookingOptions $reservation)
    {
        $this->reservation->removeElement($reservation);
    }

    /**
     * Get reservation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    public function __toString() {
        return $this->name;
    }
}
