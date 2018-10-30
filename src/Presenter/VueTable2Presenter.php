<?php

declare(strict_types=1);

namespace VueDatatableBundle\Presenter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\Provider\ResultSetInterface;

/**
 * Class VueTable2Presenter.
 *
 * @see https://ratiw.github.io/vuetable-2/#/Data-Format-JSON
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class VueTable2Presenter implements DatatablePresenterInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param RouterInterface $router
     * @param string          $routeName the route name for generating the nextPageUrl and prevPageUrl
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function createResponse(Datatable $datatable, ResultSetInterface $result): Response
    {
        $request = $datatable->getRequest();
        if ($request === null) {
            throw new \LogicException('No datatable request given for creating VueTable2 response.');
        }

        $totalPage = ceil($result->getTotal() / $request->perPage);
        $route = $datatable->getRequest()->route->name;

        $prevUrl = $this->router->generate($route, [
            'page' => $request->page - 1,
            'per_page' => $request->perPage,
            'sort' => $this->getSort($request),
        ]);
        $nextUrl = $this->router->generate($route, [
            'page' => $request->page + 1,
            'per_page' => $request->perPage,
            'sort' => $this->getSort($request),
        ]);

        return new JsonResponse([
            'total' => $result->getTotal(),
            'per_page' => $request->perPage,
            'current_page' => $request->page,
            'last_page' => ceil($result->getTotal()/$request->perPage),
            'next_page_url' => $request->page + 1 <= $totalPage ? $nextUrl : null,
            'prev_page_url' => $request->page - 1 >= 1 ? $prevUrl : null,
            'from' => ($request->page - 1) * $request->perPage + 1,
            'to' => min($result->getTotal(), $request->page * $request->perPage),
            'data' => iterator_to_array($result->getData(), true),
        ]);
    }

    protected function getSort(\VueDatatableBundle\Domain\DatatableRequest $request)
    {
        return join(',', array_map(function(\VueDatatableBundle\Domain\OrderBy $order){
            return $order->getColumn() . '|' . $order->getOrder();
        }, $request->orders));
    }
}
