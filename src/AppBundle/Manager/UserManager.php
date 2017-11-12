<?php

/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 29/05/17
 * Time: 22:39
 */

namespace AppBundle\Manager;

use \FOS\UserBundle\Model\UserManager as FosUserManager;

class UserManager
{
    /**
     * @var FosUserManager
     */
    protected $fosUserManager;

    /**
     * Constructor.
     *
     * @param FosUserManager $userManager
     */
    public function __construct(FosUserManager $userManager)
    {
        $this->fosUserManager = $userManager;
    }

}