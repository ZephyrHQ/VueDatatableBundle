<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain\Provider;

/**
 * Interface ResultSetInterface.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
final class ArrayResultSet implements ResultSetInterface
{
    private $data;
    private $total;
    private $filteredTotal;

    public function __construct(array $data, int $total = 0, int $filteredTotal = 0)
    {
        $this->data = $data;
        $this->total = $total;
        $this->filteredTotal = $filteredTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayedTotal(): int
    {
        return $this->filteredTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): \Iterator
    {
        return new \ArrayIterator($this->data);
    }

    public function format(callable $formatter)
    {
        $this->data = $formatter($this->data);
    }

}
