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
class QueryBuilderProvider implements DatatableProviderInterface, ORMAble
{
    use Traits\EntityManagerTrait;

    /**
     * @var QueryBuilderProvider
     */
    protected $queryBuilder;
    /**
     * @var array
     */
    protected $options;

    public function __construct(QueryBuilder $queryBuilder, string $rootAlias, array $options=[])
    {
        $this->queryBuilder = $queryBuilder;
        $this->options = $options;
        $this->rootAlias = $rootAlias;
    }

    protected function getRootAlias()
    {
        return $this->rootAlias;
    }

    protected function getQueryBuilder(Datatable $datatable)
    {
        $datatableRequest = $datatable->getRequest();
        $queryBuilder = clone $this->queryBuilder;
        foreach($datatableRequest->orders as $order) {
            $column = $this->getRootAlias() . '.' . $datatable->getColumn($order->getColumn())->getName();
            $queryBuilder->addOrderBy($column, $order->getOrder());
        }

        return $queryBuilder;
    }

    public function getResult(Datatable $datatable): ResultSetInterface
    {
        $idField = isset($this->options['idField']) ? $this->options['idField'] : 'id';
        $datatableRequest = $datatable->getRequest();
        $page = $datatableRequest->page;
        $perPage = $datatableRequest->perPage;

        $queryBuilderCount = $this->getQueryBuilder($datatable);
        $queryBuilderCount->select('COUNT( DISTINCT '.$this->getRootAlias().'.'.$idField.')');
        $total = $queryBuilderCount->getQuery()->getSingleScalarResult();

        $queryBuilderIds = $this->getQueryBuilder($datatable);
        $queryBuilderIds
            ->select($this->getRootAlias().'.'.$idField)
            ->distinct()
            ->setFirstResult(($page-1)*$perPage)
            ->setMaxResults($perPage)
        ;
        $ids = $queryBuilderIds->getQuery()->getArrayResult();

        $queryBuilder = $this->getQueryBuilder($datatable);
        $queryBuilder
            ->andWhere($this->getRootAlias().'.'.$idField .' IN ( :IDS )' )
            ->setParameter('IDS', $ids)
        ;
        

        $data = json_decode(json_encode($queryBuilder->getQuery()->getResult()), true);

        return new ArrayResultSet($data, $total, count($data));
    }
}
