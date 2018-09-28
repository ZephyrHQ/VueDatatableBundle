<?php

declare(strict_types=1);

namespace VueDatatableBundle\Presenter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\ResultSetInterface;

/**
 * Class VueTable2Presenter.
 * @see https://ratiw.github.io/vuetable-2/#/Data-Format-JSON
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class VueTable2Presenter implements DatatablePresenterInterface
{
    public function createResponse(Datatable $datatable, ResultSetInterface $result): Response
    {
        $request = $datatable->getRequest();
        if ($request === null) {
            throw new \LogicException('No datatable request given for creating VueTable2 response.');
        }

        return new JsonResponse([
            'links' => [
                'pagination' => [
                    'total' => $result->getTotal(),
                    'per_page' => $request->perPage,
                    'current_page' => $request->page,
//                    'last_page' => 4,
//                    'next_page_url' => '',
//                    'prev_page_url' => '',
//                    'from' => 1,
//                    'to' => 15,
                ],
            ],
            'data' => iterator_to_array($result->getData(), true),
        ]);
    }
}
