<?php

declare(strict_types=1);

namespace VueDatatableBundle\InputProcessor;

use Symfony\Component\HttpFoundation\Request;
use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\DatatableRequest;

/**
 * Class VueTable2InputProcessor.
 *
 * @see https://github.com/ratiw/vuetable-2-tutorial/wiki/prerequisite#sample-api-endpoint
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class VueTable2InputProcessor implements DatatableInputProcessorInterface
{
    /**
     * @param Request   $request (e.g., parameters from a http request)
     * @param Datatable $datatable
     *
     * @return DatatableRequest
     */
    public function process(Request $request, Datatable $datatable): DatatableRequest
    {
        $requestData = $request->isMethod('POST')
            ? $request->request->all()
            : $request->query->all();

        $datatableRequest = new DatatableRequest(
            (int) ($requestData['page'] ?? $datatable->defaultPage),
            (int) ($requestData['per_page'] ?? $datatable->defaultPerPage)
        );
        if (isset($requestData['sort'])) {
            $fields = explode(',', $requestData['sort']);
            foreach($fields as $field) {
                [$orderBy, $orderDir] = explode('|', $field);
                $datatableRequest->addOrderBy($orderBy, $orderDir);
            }
        }

        $datatableRequest->setRoute($request->get('_route'), $request->get('_route_params'));
        $datatableRequest->search = $requestData['filter'] ?? null;
        $datatableRequest->isCallback = $request->get('page', false)!==false;

        return $datatableRequest;
    }
}
