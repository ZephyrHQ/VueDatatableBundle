<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain;

use VueDatatableBundle\Domain\Column\AbstractColumn;
use VueDatatableBundle\Domain\Provider\DatatableProviderInterface;

/**
 * Class Datatable.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
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

    /**
     * @var DatatableProviderInterface
     */
    protected $provider;

    public function getProvider(): DatatableProviderInterface
    {
        return $this->provider;
    }

    public function setProvider(DatatableProviderInterface $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function addColumn(AbstractColumn $column): self
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * @param string $colName the name of column
     *
     * @return null|AbstractColumn null if not found
     */
    public function findColumn(string $colName): ?AbstractColumn
    {
        foreach ($this->columns as $column) {
            if ($colName === $column->getName()) {
                return $column;
            }
        }

        return null;
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
