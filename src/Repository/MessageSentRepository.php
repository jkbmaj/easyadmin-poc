<?php

namespace App\Repository;

use App\Entity\MessageSent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MessageSent>
 *
 * @method MessageSent|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageSent|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageSent[]    findAll()
 * @method MessageSent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageSentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageSent::class);
    }
}
