<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function save(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTeamsPaginator(int $page, int $pageSize, ?string $countryFilter = null): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('t');

        if ($countryFilter) {
            $queryBuilder->andWhere('t.country = :country')
                ->setParameter('country', $countryFilter);
        }

        // Comptage total des résultats
        $queryBuilder->select('COUNT(t.id)');
        $totalResults = (int) $queryBuilder->getQuery()->getSingleScalarResult();

        // Requête paginée
        $queryBuilder->select('t')
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);

        $query = $queryBuilder->getQuery();

        return new Paginator($query, true);
    }
}
