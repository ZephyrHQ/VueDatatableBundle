<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VueDatatableBundle\Domain\Provider;

use VueDatatableBundle\Domain\Datatable;

/**
 * Description of ArrayProvider
 *
 * @author nico
 */
class ArrayProvider implements DatatableProviderInterface
{
    public function __construct(array $array)
    {
        $this->data = $array;
    }

    public function getResult(Datatable $datatable): ResultSetInterface
    {
        $datatableRequest = $datatable->getRequest();
        $page = $datatableRequest->page;
        $perPage = $datatableRequest->perPage;
        $orderBy = $datatableRequest->orderBy->getName();
        $orderDir = $datatableRequest->orderDir;
        $array = clone $this->data;
        usort($array, function($item1, $item2)use($orderBy, $orderDir){
            return $orderDir==='asc' && $item1[$orderBy] > $item2[$orderBy];
        });

        $data = array_slice($this->data, ($page-1)*$perPage, $perPage);

        return new ArrayResultSet($data, \count($this->data), \count($data));
    }
}
