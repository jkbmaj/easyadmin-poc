<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\NewsletterTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsletterTemplate>
 *
 * @method null|NewsletterTemplate find($id, $lockMode = null, $lockVersion = null)
 * @method null|NewsletterTemplate findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterTemplate[] findAll()
 * @method NewsletterTemplate[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterTemplate::class);
    }
}
