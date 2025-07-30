<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }


    // query builder créer à la main. , il sert à classer les commentaires des commentaires par ordre de création
    // lorsqu'ils s'affichent.
    public function findFullById(string $id): ?Message
    {
        return $this->createQueryBuilder('m')
            ->select('m', 'c')
            ->leftJoin('m.children', 'c')
            ->where('m.id = :id')
            ->setParameter('id', $id)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
