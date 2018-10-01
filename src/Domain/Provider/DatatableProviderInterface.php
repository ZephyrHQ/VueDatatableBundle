<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain\Provider;

use VueDatatableBundle\Domain\Datatable;

/**
 * Interface DatatableProviderInterface.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
interface DatatableProviderInterface
{
    public function getResult(Datatable $datatable): ResultSetInterface;
}
