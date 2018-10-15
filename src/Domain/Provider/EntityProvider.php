<?php

namespace VueDatatableBundle\Domain\Provider;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use VueDatatableBundle\Domain\Datatable;

/**
 * Description of ArrayProvider
 *
 * @author nico
 */
class EntityProvider implements DatatableProviderInterface, ORMAble
{
    use Traits\EntityManagerTrait;

    /**
     * @var string
     */
    protected $entity;
    /**
     * @var array
     */
    protected $options;

    public function __construct($entity, array $options=[])
    {
        $this->entity = $entity;
        $this->options = $options;
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository($this->entity)->createQueryBuilder($this->entity);
    }

    public function getResult(Datatable $datatable): ResultSetInterface
    {
        $datatableRequest = $datatable->getRequest();
        $page = $datatableRequest->page;
        $perPage = $datatableRequest->perPage;
        $orderBy = $datatableRequest->orderBy->getName();
        $orderDir = $datatableRequest->orderDir;

        $queryBuilderCount = $this->getQueryBuilder();
        $queryBuilderCount->select('COUNT('.$this->entity.')');
        $total = $queryBuilderCount->getQuery()->getSingleScalarResult();

        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
            ->addOrderBy($orderBy, $orderDir)
            ->setFirstResult(($page-1)*$perPage)
            ->setMaxResult($perPage)
        ;

        $data = $queryBuilder->getQuery()->getArrayResult();

        return new ArrayResultSet($data, $total, count($data));
    }
}
