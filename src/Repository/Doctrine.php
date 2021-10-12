<?php

namespace App\Repository;

trait Doctrine
{
    public function save($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function softDelete($entity)
    {
        $entity->setDeletedAt();
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}