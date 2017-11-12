<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agency
 *
 * @ORM\Table(name="agency", indexes={@ORM\Index(name="FK_773DE69D4D42DB2D", columns={"pick_up_agency_id"})})
 * @ORM\Entity
 */
class Agency
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=255, nullable=false)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="tva_number", type="string", length=255, nullable=false)
     */
    private $tvaNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_address", type="string", length=255, nullable=true)
     */
    private $billingAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_zip_code", type="string", length=255, nullable=true)
     */
    private $billingZipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_city", type="string", length=255, nullable=true)
     */
    private $billingCity;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_country", type="string", length=255, nullable=true)
     */
    private $billingCountry;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var PickUpCenter
     *
     * @ORM\ManyToOne(targetEntity="PickUpCenter")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pick_up_agency_id", referencedColumnName="id")
     * })
     */
    private $pickUpAgency;



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
     * @return Agency
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
     * Set siret
     *
     * @param string $siret
     *
     * @return Agency
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set tvaNumber
     *
     * @param string $tvaNumber
     *
     * @return Agency
     */
    public function setTvaNumber($tvaNumber)
    {
        $this->tvaNumber = $tvaNumber;

        return $this;
    }

    /**
     * Get tvaNumber
     *
     * @return string
     */
    public function getTvaNumber()
    {
        return $this->tvaNumber;
    }

    /**
     * Set billingAddress
     *
     * @param string $billingAddress
     *
     * @return Agency
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * Get billingAddress
     *
     * @return string
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Set billingZipCode
     *
     * @param string $billingZipCode
     *
     * @return Agency
     */
    public function setBillingZipCode($billingZipCode)
    {
        $this->billingZipCode = $billingZipCode;

        return $this;
    }

    /**
     * Get billingZipCode
     *
     * @return string
     */
    public function getBillingZipCode()
    {
        return $this->billingZipCode;
    }

    /**
     * Set billingCity
     *
     * @param string $billingCity
     *
     * @return Agency
     */
    public function setBillingCity($billingCity)
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    /**
     * Get billingCity
     *
     * @return string
     */
    public function getBillingCity()
    {
        return $this->billingCity;
    }

    /**
     * Set billingCountry
     *
     * @param string $billingCountry
     *
     * @return Agency
     */
    public function setBillingCountry($billingCountry)
    {
        $this->billingCountry = $billingCountry;

        return $this;
    }

    /**
     * Get billingCountry
     *
     * @return string
     */
    public function getBillingCountry()
    {
        return $this->billingCountry;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Agency
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
     * Set pickUpAgency
     *
     * @param \AppBundle\Entity\PickUpCenter $pickUpAgency
     *
     * @return Agency
     */
    public function setPickUpAgency(\AppBundle\Entity\PickUpCenter $pickUpAgency = null)
    {
        $this->pickUpAgency = $pickUpAgency;

        return $this;
    }

    /**
     * Get pickUpAgency
     *
     * @return \AppBundle\Entity\PickUpCenter
     */
    public function getPickUpAgency()
    {
        return $this->pickUpAgency;
    }

    public function __toString() {
        return $this->name;
    }
}
