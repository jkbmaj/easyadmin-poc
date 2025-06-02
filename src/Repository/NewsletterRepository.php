<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Newsletter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Newsletter>
 *
 * @method null|Newsletter find($id, $lockMode = null, $lockVersion = null)
 * @method null|Newsletter findOneBy(array $criteria, array $orderBy = null)
 * @method Newsletter[] findAll()
 * @method Newsletter[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Newsletter::class);
    }
}
