<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain;

use VueDatatableBundle\Domain\Column\AbstractColumn;
use VueDatatableBundle\Domain\Provider\DatatableProviderInterface;
use VueDatatableBundle\Domain\Provider\ResultSetInterface;

/**
 * Class Datatable.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class Datatable
{
    /**
     * @var int
     */
    public $defaultPage = 1;

    /**
     * @var int
     */
    public $defaultPerPage = 10;

    /**
     * @var ResultSetInterface
     */
    protected $resultSet;

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

    public function addColumn(string $name, string $class, array $options = []): self
    {
        if (!is_subclass_of($class, AbstractColumn::class)) {
            throw new \RuntimeException(sprintf('$class must be an %s object, %s given.', AbstractColumn::class, $class));
        }
        $this->columns[$name] = new $class($name, $options);

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
