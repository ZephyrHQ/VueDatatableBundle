<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain\Type;

use VueDatatableBundle\Domain\Datatable;

/**
 * Class AbstractDatatableType.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
abstract class AbstractDatatableType
{
    /**
     * @param Datatable $datatable
     */
    abstract public function configure(Datatable $datatable): void;
}
