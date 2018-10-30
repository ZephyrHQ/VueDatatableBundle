<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain;

use VueDatatableBundle\Domain\Column\AbstractColumn;

/**
 * Class DatatableRequest.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class DatatableRequest
{
    public const ORDER_ASC = 'asc';
    public const ORDER_DESC = 'desc';

    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $perPage;

    /**
     * @var OrderBy[]
     */
    public $orders;

    /**
     * @var array
     */
    public $route;

    /**
     * @var array
     */
    public $filters;

    /**
     * @var array
     */
    public $search;

    /**
     * @var boolean
     */
    public $isCallback = false;

    public function __construct(int $page, int $perPage)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function addOrderBy($field, $direction)
    {
        $this->orders[] = new OrderBy($field, $direction);
    }


    public function setRoute($name, $parameters)
    {
        $this->route = new \stdClass();
        $this->route->name = $name;
        $this->route->parameters = $parameters;

        return $this;
    }
//    public $filters;
}
