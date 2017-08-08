<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PickUpCenter
 *
 * @ORM\Table(name="pick_up_center")
 * @ORM\Entity
 */
class PickUpCenter
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
     * @var Agency
     *
     * @ORM\ManyToOne(targetEntity="Agency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agency_id", referencedColumnName="id")
     * })
     */
    protected $agency;

    /**
     * @var string
     *
     * @ORM\Column(name="opening_hours", type="text", nullable=false)
     */
    private $openingHours;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

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
     * Set openingHours
     *
     * @param string $openingHours
     *
     * @return PickUpCenter
     */
    public function setOpeningHours($openingHours)
    {
        $this->openingHours = $openingHours;

        return $this;
    }

    /**
     * Get openingHours
     *
     * @return string
     */
    public function getOpeningHours()
    {
        return $this->openingHours;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return PickUpCenter
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * get Agency
     *
     * @return Agency
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * set agency
     *
     * @param Agency $agency
     *
     * @return self
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;

        return $this;
    }
}
