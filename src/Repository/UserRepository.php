<?php

namespace App\Repository;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method find($id, $lockMode = null, $lockVersion = null)
 * @method findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
 * @method findAll()
 * @method findOneBy(array $criteria, ?array $orderBy = null)
 */
class UserRepository extends ServiceEntityRepository
{
    use Doctrine;

    public function __construct(ManagerRegistry $registry )
    {
        parent::__construct($registry, User::class);
    }

    public function filterUsers(?string $firstName, ?string $lastName, ?string $email, ?string $role)
    {
        $condition = ['deletedAt' => null];
        if ($firstName) {
            $condition['firstName'] = $firstName;
        }
        if ($lastName) {
            $condition['lastName'] = $lastName;
        }
        if ($email) {
            $condition['email'] = $email;
        }
        if ($role) {
            $condition['role'] = $this->getEntityManager()->getRepository(Role::class)->findBy(['name' => $role]);
        }
        return $this->findBy($condition);
    }
}