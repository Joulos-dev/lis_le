<?php

namespace App\Repository;

use App\Entity\Message;
use App\Enum\MessageType;
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

    public function searchByQuery(?string $query): array
    {
        if (!$query) {
            return []; // Retourne un tableau vide si la requête est vide
        }

        return $this->createQueryBuilder('p') // 'p' est un alias pour Product
            ->andWhere('p.title LIKE :query OR p.content LIKE :query')
            ->andWhere('p.type = :type')// Adaptez les champs de recherche
            ->setParameter('query', '%' . $query . '%')
            ->setParameter('type', MessageType::MESSAGE_TYPE_POST)// Ajoute des wildcards pour une recherche partielle
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getAll()
    {
        return $this->createQueryBuilder('m')
            ->andWhere("m.type = :type")
            ->setParameter('type', MessageType::MESSAGE_TYPE_POST);
    }

}


