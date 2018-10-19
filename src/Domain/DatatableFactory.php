<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain;

use VueDatatableBundle\Domain\Type\AbstractDatatableType;
use VueDatatableBundle\Domain\Type\DatatableTypeRegistry;

/**
 * Class DatatableFactory.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class DatatableFactory
{
    /**
     * @var DatatableTypeRegistry
     */
    private $registry;

    public function __construct(DatatableTypeRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param string $typeClass
     *
     * @return Datatable
     */
    public function createFromType(string $typeClass): Datatable
    {
        if (!is_subclass_of($typeClass, AbstractDatatableType::class)) {
            throw new \RuntimeException(sprintf('$typeClass must be an %s object, %s given.', AbstractDatatableType::class, $typeClass));
        }
        $type = $this->registry->getType($typeClass);

        $dt = new Datatable();
        $type->configure($dt);

        return $dt;
    }
}
