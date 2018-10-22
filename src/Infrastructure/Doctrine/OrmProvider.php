<?php

declare(strict_types=1);

namespace VueDatatableBundle\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\DatatableRequest;
use VueDatatableBundle\Domain\Provider\ArrayResultSet;
use VueDatatableBundle\Domain\Provider\DatatableProviderInterface;
use VueDatatableBundle\Domain\Provider\ResultSetInterface;

/**
 * Class OrmProvider.
 * A basic provider for Doctrine ORM entities.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class OrmProvider implements DatatableProviderInterface
{
    /**
     * @var RegistryInterface
     */
    protected $registry;

    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * @var ClassMetadata
     */
    protected $entityMetadata;

    public function __construct(RegistryInterface $registry, ?string $entityClass = null)
    {
        $this->registry = $registry;
        if ($entityClass !== null) {
            $this->setEntityClass($entityClass);
        }
    }

    /**
     * @param string $entityClass the FQCN of an entity
     */
    public function setEntityClass(string $entityClass): void
    {
        if (null === ($this->manager = $this->registry->getManagerForClass($entityClass))) {
            throw new \RuntimeException(sprintf('Doctrine has no manager for entity "%s", is it correctly imported and referenced?', $entityClass));
        }
        $this->entityMetadata = $this->manager->getClassMetadata($entityClass);
    }

    protected function createQueryBuilder(): QueryBuilder
    {
        return $this->manager->createQueryBuilder();
    }

    /**
     * {@inheritdoc}
     */
    public function getResult(Datatable $datatable): ResultSetInterface
    {
        $datatableRequest = $datatable->getRequest();
        if ($datatableRequest === null) {
            throw new \RuntimeException('No datatable request found. Handle input first.');
        }

        if ($this->entityMetadata === null) {
            throw new \RuntimeException('No entity class set. Please setEntityClass().');
        }

        $page = $datatableRequest->page;
        $perPage = $datatableRequest->perPage;
        $orderBy = $datatableRequest->orderBy->getName();
        $orderDir = $datatableRequest->orderDir;

        $entityName = $this->entityMetadata->getName();
        $entityShortName = mb_strtolower($this->entityMetadata->getReflectionClass()->getShortName());

        $qb = $this->createQueryBuilder();

        // TODO : add (custom) criteria
        $total = $qb->select('COUNT(*)')->from($entityName, $entityShortName)->getQuery()->getSingleScalarResult();

        $qb
            ->from($entityName, $entityShortName)
            ->addOrderBy($orderBy, $orderDir === DatatableRequest::ORDER_DESC ? 'DESC' : 'ASC')
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($perPage);
        $data = $qb->getQuery()->getArrayResult();

        return new ArrayResultSet($data, $total, \count($data));
    }
}
