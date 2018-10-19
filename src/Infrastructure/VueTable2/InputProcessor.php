<?php

declare(strict_types=1);

namespace VueDatatableBundle\Infrastructure\VueTable2;

use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\DatatableRequest;
use VueDatatableBundle\Domain\InputProcessor\DatatableInputProcessorInterface;

/**
 * Class InputProcessor.
 *
 * @see https://github.com/ratiw/vuetable-2-tutorial/wiki/prerequisite#sample-api-endpoint
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class InputProcessor implements DatatableInputProcessorInterface
{
    /**
     * @see https://www.vuetable.com/api/vuetable/properties.html#query-params
     *
     * @param array     $requestData (e.g., parameters from a http request)
     * @param Datatable $datatable
     *
     * @return DatatableRequest
     */
    public function process(array $requestData, Datatable $datatable): DatatableRequest
    {
        $orderBy = $orderDir = null;
        if (isset($requestData['sort'])) {
            [$colName, $orderDir] = explode('|', $requestData['sort']);
            $orderBy = $datatable->findColumn($colName);
        }

        $datatableRequest = new DatatableRequest(
            (int) max($requestData['page'] ?? $datatable->defaultPage, 1),
            (int) ($requestData['per_page'] ?? $datatable->defaultPerPage),
            $orderBy,
            $orderDir
        );
        $datatableRequest->search = $requestData['filter'] ?? null;

        return $datatableRequest;
    }
}
