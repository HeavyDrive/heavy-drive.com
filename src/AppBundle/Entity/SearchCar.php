<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 11/03/18
 * Time: 21:33
 */

namespace AppBundle\Entity;


class SearchCar
{
    protected $agency;
    protected $agencyRetour;
    protected $startDate;
    protected $endDate;

    /**
     * @return mixed
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;
    }

    /**
     * @return mixed
     */
    public function getAgencyRetour()
    {
        return $this->agencyRetour;
    }

    /**
     * @param mixed $agencyRetour
     */
    public function setAgencyRetour($agencyRetour)
    {
        $this->agencyRetour = $agencyRetour;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }



}