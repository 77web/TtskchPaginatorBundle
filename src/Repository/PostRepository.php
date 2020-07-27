<?php

declare(strict_types=1);

namespace App\Repository;

use App\Criteria\PostCriteria;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Ttskch\PaginatorBundle\Doctrine\Counter;
use Ttskch\PaginatorBundle\Doctrine\Slicer;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function sliceByCriteria(PostCriteria $criteria): \ArrayIterator
    {
        $qb = $this->createQueryBuilderFromCriteria($criteria);
        $slicer = new Slicer($qb);

        return $slicer($criteria);
    }

    public function countByCriteria(PostCriteria $criteria): int
    {
        $qb = $this->createQueryBuilderFromCriteria($criteria);
        $counter = new Counter($qb);

        return $counter($criteria);
    }

    private function createQueryBuilderFromCriteria(PostCriteria $criteria): QueryBuilder
    {
        $qb = $this->createQueryBuilder('p')
            ->orWhere('p.subject like :query')
            ->orWhere('p.body like :query')
            ->setParameter('query', '%'.str_replace('%', '\%', $criteria->query).'%')
        ;

        if ($criteria->after) {
            $qb
                ->andWhere('p.date >= :after')
                ->setParameter('after', $criteria->after)
            ;
        }

        if ($criteria->before) {
            $qb
                ->andWhere('p.date <= :before')
                ->setParameter('before', $criteria->before)
            ;
        }

        return $qb;
    }
}
