<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 24/07/17
 * Time: 20:45
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Identitiy Card Customer
 *
 * @ORM\Table(name="identity_card")
 * @ORM\Entity
 */
class IdentityCard
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

}