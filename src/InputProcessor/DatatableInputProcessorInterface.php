<?php

declare(strict_types=1);

namespace VueDatatableBundle\InputProcessor;

use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\DatatableRequest;

/**
 * Interface DatatableInputProcessorInterface.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
interface DatatableInputProcessorInterface
{
    public function process(array $requestData, Datatable $datatable): DatatableRequest;
}
