<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain\Type;

use Psr\Container\ContainerInterface;

/**
 * Class DatatableTypeRegistry.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class TypeRegistry
{
    /**
     * @var ContainerInterface
     */
    private $locator;

    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public function getType($typeName): DatatableTypeInterface
    {
        if ($this->locator->has($typeName)) {
            return $this->locator->get($typeName);
        }

        throw new \Exception(sprintf('Type should exist as a service. %s given', $typeName));
    }
}