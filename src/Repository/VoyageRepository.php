<?php

namespace App\Repository;

use App\Entity\Voyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Voyage>
 */
class VoyageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voyage::class);
    }

    public function findBySearch(?string $query, array $searchPlanets, int $limit = null): array
    {
        $qb =  $this->findBySearchQueryBuilder($query, $searchPlanets);

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function findBySearchQueryBuilder(?string $query, array $searchPlanets, ?string $sort = null, string $direction = 'DESC'): QueryBuilder
    {
        $qb = $this->createQueryBuilder('v');

        if ($query) {
            $qb->andWhere('v.purpose LIKE :query')
                ->setParameter('query', '%' . $query . '%');
        }

        if ($searchPlanets) {
            $qb->andWhere('v.planet IN (:planets)')
                ->setParameter('planets', $searchPlanets);
        }

        if ($sort) {
            $qb->orderBy('v.' . $sort, $direction);
        }

        return $qb;
    }
}
