<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain\Type;

use Psr\Container\ContainerInterface;

/**
 * Class DatatableTypeRegistry.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class DatatableTypeRegistry
{
    /**
     * @var ContainerInterface
     */
    private $locator;

    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public function getType($id): AbstractDatatableType
    {
        if ($this->locator->has($id)) {
            return $this->locator->get($id);
        }

        return new $id();
    }
}
