<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain;

/**
 * Class DatatableRoute.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class DatatableRoute
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $parameters;

    public function __construct(string $name, array $parameters = [])
    {
        $this->name = $name;
        $this->parameters = $parameters;
    }
}
