<?php

declare(strict_types=1);

namespace VueDatatableBundle\Interactor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\Provider\ResultSetInterface;
use VueDatatableBundle\InputProcessor\DatatableInputProcessorInterface;
use VueDatatableBundle\Presenter\DatatablePresenterInterface;

/**
 * Class DatatableInteractor.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class DatatableInteractor implements DatatableInteractorInterface
{
    /**
     * @var DatatableInputProcessorInterface
     */
    private $inputProcessor;

    /**
     * @var DatatablePresenterInterface
     */
    private $presenter;

    public function __construct(
        DatatableInputProcessorInterface $inputProcessor,
        DatatablePresenterInterface $presenter)
    {
        $this->inputProcessor = $inputProcessor;
        $this->presenter = $presenter;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Datatable $datatable, Request $request): ResultSetInterface
    {
        return $this->submit($datatable, $request->isMethod('POST')
            ? $request->request->all()
            : $request->query->all());
    }

    /**
     * {@inheritdoc}
     */
    public function submit(Datatable $datatable, array $requestData): ResultSetInterface
    {
        $request = $this->inputProcessor->process($requestData, $datatable);
        $datatable->setRequest($request);

        if ($datatable->getProvider() === null) {
            throw new \RuntimeException('No datatable provider set in the Datatable object.');
        }

        return $datatable->getProvider()->getResult($datatable);
    }

    /**
     * {@inheritdoc}
     */
    public function createResponse(Datatable $datatable, ResultSetInterface $result): Response
    {
        return $this->presenter->createResponse($datatable, $result);
    }
}
