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

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
