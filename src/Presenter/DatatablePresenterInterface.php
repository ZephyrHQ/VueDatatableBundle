<?php

declare(strict_types=1);

namespace VueDatatableBundle\Presenter;

use Symfony\Component\HttpFoundation\Response;
use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\ResultSetInterface;

interface DatatablePresenterInterface
{
    public function createResponse(Datatable $datatable, ResultSetInterface $result): Response;
}
