<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method find($id, $lockMode = null, $lockVersion = null)
 * @method findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
 * @method findAll()
 * @method findOneBy(array $criteria, ?array $orderBy = null)
 */
class RoleRepository extends ServiceEntityRepository
{
    use Doctrine;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    public function filterRoles(?string $query, string $status)
    {
        $condition = [];
        if ($query) {
            $condition = ['name' => $query];
        }
        switch ($status) {
            case 'all':
                return $this->findBy($condition);
            case 'archived':
                $queryBuilder = $this->getEntityManager()->createQueryBuilder();
                $queryBuilder->select('r')
                    ->from(Role::class, 'r')
                    ->where($queryBuilder->expr()
                    ->isNotNull('r.deletedAt'))
                    ;
                if (isset($condition['name'])) {
                    $queryBuilder->andWhere('r.name = :name')->setParameter('name', $condition['name'] ?? '');
                }
                return $queryBuilder->getQuery()
                    ->getResult();
            case 'active':
            default:
                $condition['deletedAt'] = null;
                return $this->findBy($condition);
        }
    }
}