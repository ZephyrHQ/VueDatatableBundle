<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain\InputProcessor;

use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\DatatableRequest;

/**
 * Interface DatatableInputProcessorInterface.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
interface DatatableInputProcessorInterface
{
    /**
     * Process raw data from datatable and returns a normalized request.
     *
     * @param array     $request   the raw datatable data
     * @param Datatable $datatable
     *
     * @return DatatableRequest
     */
    public function process(array $request, Datatable $datatable): DatatableRequest;
}
