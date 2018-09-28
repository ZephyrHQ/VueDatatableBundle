<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain;

use VueDatatableBundle\Domain\Column\AbstractColumn;

class Datatable
{
    /**
     * @var AbstractColumn[]
     */
    protected $columns;

    /**
     * @var DatatableRequest
     */
    protected $request;

    public function addColumn(AbstractColumn $column): self
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * Get Request.
     *
     * @return DatatableRequest|null
     */
    public function getRequest(): ?DatatableRequest
    {
        return $this->request;
    }

    /**
     * @param DatatableRequest|null $request
     *
     * @return Datatable
     */
    public function setRequest(?DatatableRequest $request): self
    {
        $this->request = $request;

        return $this;
    }
}
