<?php

declare(strict_types=1);

namespace VueDatatableBundle\InputProcessor;

use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\DatatableRequest;

/**
 * Class VueTable2InputProcessor.
 * @see https://github.com/ratiw/vuetable-2-tutorial/wiki/prerequisite#sample-api-endpoint
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class VueTable2InputProcessor implements DatatableInputProcessorInterface
{
    /**
     * @param array     $requestData (e.g., parameters from a http request)
     * @param Datatable $datatable
     *
     * @return DatatableRequest
     */
    public function process(array $requestData, Datatable $datatable): DatatableRequest
    {
        return new DatatableRequest(
            (int) ($requestData['page'] ?? 1),
            (int) ($requestData['per_page'] ?? 10),
            null,
            null
        );
    }
}
