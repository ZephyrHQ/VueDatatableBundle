<?php

namespace VueDatatableBundle\Domain\Type;

use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\Provider\DatatableProviderInterface;

/**
 * Description of TypeInterface
 *
 * @author nico
 */
interface DatatableTypeInterface
{
    public function configure(Datatable $datatable, array $options);
}
