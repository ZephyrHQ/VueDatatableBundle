<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VueDatatableBundle\Domain;

/**
 * Description of Order
 *
 * @author nico
 */
class OrderBy
{
    protected $column;
    protected $order;

    public function __construct($column, $order)
    {
        $this->column = $column;
        $this->order = $order;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setColumn($column)
    {
        $this->column = $column;
        return $this;
    }

    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }


}
