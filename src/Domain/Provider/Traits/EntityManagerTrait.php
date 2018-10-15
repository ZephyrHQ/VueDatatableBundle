<?php

namespace VueDatatableBundle\Domain\Provider\Traits;

use Doctrine\ORM\EntityManager;

/**
 * Description of EntityManagerTrait
 *
 * @author nico
 */
trait EntityManagerTrait
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

}
