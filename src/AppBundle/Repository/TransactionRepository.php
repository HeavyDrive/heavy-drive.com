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

       $qb ->add('select', 't')
        ->add('from', 'Transaction t')
        ->add('where', 't.transactionId = ?1')
        ->add('orderBy', 't.transactionId DESC');

        dump($qb->getQuery()->getFirstResult());
        /*$qb->andWhere('transaction.transactionId = :transactionId');
        $qb->setParameter('transactionId', "?1");
        $qb->orderBy("ASC");*/

        return $qb;
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