<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Recipient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipient>
 *
 * @method null|Recipient find($id, $lockMode = null, $lockVersion = null)
 * @method null|Recipient findOneBy(array $criteria, array $orderBy = null)
 * @method Recipient[] findAll()
 * @method Recipient[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipient::class);
    }

    public function save(Recipient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
