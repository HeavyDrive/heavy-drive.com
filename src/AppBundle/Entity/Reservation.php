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
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="FK_773DE69D4D42DB17D", columns={"client_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * Booking status.
     */
    const STATUS_CREATED     = 0; // Booking done
    const STATUS_WAITTING    = 5; // Booking waitting confirmation
    const STATUS_ACCEPTED    = 10; //Booking confirmed
    const STATUS_IN_PROGRESS = 15; //Booking in progress
    const STATUS_SOLD        = 20; //Booking paid
    const STATUS_NOT_SOLD    = 25; //Waitting payment
    const STATUS_CLOSED      = 30; //Booking closed
    const STATUS_CANCELLED   = 35; //Booking cancelled

    public static $statuses = [
        self::STATUS_CREATED     => 'reservation.status.created', // Booking done
        self::STATUS_WAITTING    => 'reservation.status.waitting',// Booking waitting confirmation
        self::STATUS_ACCEPTED    => 'reservation.status.accepted', //Booking confirmed
        self::STATUS_IN_PROGRESS => 'reservation.status.in_progress', //Booking in progress
        self::STATUS_SOLD        => 'reservation.status.sold', //Booking paid
        self::STATUS_NOT_SOLD    => 'reservation.status.not_sold', //Waitting payment
        self::STATUS_CLOSED      => 'reservation.status.closed', //Booking closed
        self::STATUS_CANCELLED   => 'reservation.status.cancelled', //Booking cancelled
    ];

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
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    protected $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime")
     */
    protected $dateEnd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

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
     * @return PickUpCenter
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

    /**
     * get Status
     *
    * @return int
    */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param int $status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get DateStart
     *
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return self
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return self
     */
    public function setDateEnd(\DateTime $dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get CreatedAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set CreatedAt
     *
     * @param \DateTime $createdAt
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

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
     * Set UpdatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
