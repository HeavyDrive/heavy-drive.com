<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 24/02/18
 * Time: 23:10
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TransactionRepository extends EntityRepository
{
    public function getLastTransactionId()
    {
        $qb = $this->createTransactionQueryBuilder();
        $qb->select('transaction.transactionId');
        $qb->orderBy('transaction.transactionId', 'DESC');
        $qb->setMaxResults(1);
        return $qb->getQuery()->getResult();
    }
    /*
    * @return \Doctrine\ORM\QueryBuilder
    */
    protected function createTransactionQueryBuilder()
    {
        $qb = $this->createQueryBuilder('transaction');
        return $qb;
    }
}