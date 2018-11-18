<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain;

use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\DatatableRequest;
use VueDatatableBundle\Domain\Provider\DatatableProviderInterface;
use VueDatatableBundle\InputProcessor\DatatableInputProcessorInterface;
use VueDatatableBundle\Presenter\DatatablePresenterInterface;

/**
 * Class DatatableInteractor.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class DatatableInteractor
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
    public function handleRequest(Datatable $datatable, Request $request): DatatableRequest
    {
        return $this->inputProcessor->process($request, $datatable);
    }

    /**
     * {@inheritdoc}
     */
    public function createResponse(Datatable $datatable): Response
    {
        if ( ! ($provider = $datatable->getProvider()) instanceof DatatableProviderInterface) {
            throw new RuntimeException('No suitable datatable provider set in the Datatable object.');
        }
        $resulset = $provider->getResult($datatable);
        if(is_callable($datatable->getFormatter())) {
            $resulset->format($datatable->getFormatter());
        }

        return $this->presenter->createResponse($datatable, $resulset);
    }
}
