<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain\Column;

/**
 * Class AbstractColumn.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
abstract class AbstractColumn
{
    protected $name;

    protected $options;

    public function __construct(string $name, array $options = [])
    {
        $this->name = $name;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
