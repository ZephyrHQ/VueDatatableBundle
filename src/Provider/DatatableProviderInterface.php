<?php

declare(strict_types=1);

namespace VueDatatableBundle\Provider;

use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\ResultSetInterface;

/**
 * Interface DatatableProviderInterface.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
interface DatatableProviderInterface
{
    public function getResult(Datatable $datatable): ResultSetInterface;
}
