<?php

declare(strict_types=1);

namespace VueDatatableBundle\Infrastructure\VueTable2;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\Presenter\DatatablePresenterInterface;
use VueDatatableBundle\Domain\Provider\ResultSetInterface;

/**
 * Class Presenter.
 *
 * @see https://ratiw.github.io/vuetable-2/#/Data-Format-JSON
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class Presenter implements DatatablePresenterInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param RouterInterface $router
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
        $route = $datatable->getRequest()->route;

        $prevUrl = $this->router->generate($route->name, array_merge($route->parameters, [
            'page' => max($request->page - 1, 1),
            'per_page' => $request->perPage,
            'sort' => $request->orderBy ? $request->orderBy->getName().'|'.$request->orderDir : null,
        ]));
        $nextUrl = $this->router->generate($route->name, array_merge($route->parameters, [
            'page' => min($request->page + 1, $totalPage),
            'per_page' => $request->perPage,
            'sort' => $request->orderBy ? $request->orderBy->getName().'|'.$request->orderDir : null,
        ]));

        return new JsonResponse([
            'links' => [
                'pagination' => [
                    'total' => $result->getTotal(),
                    'per_page' => $request->perPage,
                    'current_page' => $request->page,
                    'next_page_url' => $request->page + 1 <= $totalPage ? $nextUrl : null,
                    'prev_page_url' => $request->page - 1 >= 1 ? $prevUrl : null,
                    'from' => min($result->getTotal(), ($request->page - 1) * $request->perPage + 1),
                    'to' => min($result->getTotal(), $request->page * $request->perPage),
                ],
            ],
            'data' => iterator_to_array($result->getData(), true),
        ]);
    }
}
