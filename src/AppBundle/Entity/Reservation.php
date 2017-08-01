<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 24/07/17
 * Time: 20:05
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="FK_773DE69D4D42DB17D", columns={"client_id"}), @ORM\Index(name="FK_773DE69D4D42DB18D", columns={"reservation_id"})})
 * @ORM\Entity
 */
class Reservation
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
     * @var PickUpCenter
     *
     * @ORM\ManyToOne(targetEntity="PickUpCenter")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pick_up_location_id", referencedColumnName="id")
     * })
     */
    private $pickUpLocationId;

    /**
     * @var PickUpCenter
     *
     * @ORM\ManyToOne(targetEntity="PickUpCenter")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="drop_off_location_id", referencedColumnName="id")
     * })
     */
    private $dropOffLocationId;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $client;

    /**
     * @var Car
     *
     * @ORM\OneToOne(targetEntity="Car", cascade={"persist"})
     */
    protected $car;

    /**
     * @var LicenseDriver
     *
     * @ORM\OneToOne(targetEntity="LicenseDriver", cascade={"persist"})
     * @ORM\JoinColumn(name="license_driver_id", nullable=false)
     */
    protected $licenceDriver;

    /**
     * @var ProofOfAdress
     *
     * @ORM\OneToOne(targetEntity="ProofOfAdress", cascade={"persist"})
     */
    protected $proofOfAdress;

    /**
     * @var IdentityCard
     *
     * @ORM\OneToOne(targetEntity="IdentityCard", cascade={"persist"})
     */
    protected $identityCard;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return PickUpCenter
     */
    public function getPickUpLocationId()
    {
        return $this->pickUpLocationId;
    }

    /**
     * @param PickUpCenter $pickUpLocationId
     */
    public function setPickUpLocationId($pickUpLocationId)
    {
        $this->pickUpLocationId = $pickUpLocationId;
    }

    /**
     * @return int
     */
    public function getDropOffLocationId()
    {
        return $this->dropOffLocationId;
    }

    /**
     * @param int $dropOffLocationId
     */
    public function setDropOffLocationId($dropOffLocationId)
    {
        $this->dropOffLocationId = $dropOffLocationId;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return LicenseDriver
     */
    public function getLicenceDriver()
    {
        return $this->licenceDriver;
    }

    /**
     * @param LicenseDriver $licenceDriver
     */
    public function setLicenceDriver($licenceDriver)
    {
        $this->licenceDriver = $licenceDriver;
    }

    /**
     * @return ProofOfAdress
     */
    public function getProofOfAdress()
    {
        return $this->proofOfAdress;
    }

    /**
     * @param ProofOfAdress $proofOfAdress
     */
    public function setProofOfAdress($proofOfAdress)
    {
        $this->proofOfAdress = $proofOfAdress;
    }

    /**
     * @return IdentityCard
     */
    public function getIdentityCard()
    {
        return $this->identityCard;
    }

    /**
     * @param IdentityCard $identityCard
     */
    public function setIdentityCard($identityCard)
    {
        $this->identityCard = $identityCard;
    }

    /**
     * @return Car
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param Car $car
     *
     * @return self
     */
    public function setCar(Car $car)
    {
        $this->car = $car;

        return $this;
    }


}