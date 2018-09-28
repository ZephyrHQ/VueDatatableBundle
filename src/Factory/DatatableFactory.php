<?php

declare(strict_types=1);

namespace VueDatatableBundle\Factory;

use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Interactor\DatatableInteractor;
use VueDatatableBundle\Interactor\DatatableInteractorInterface;
use VueDatatableBundle\Presenter\DatatablePresenterInterface;

class DatatableFactory
{
    public static function createDatatableInteractor(Datatable $datatable, ?DatatablePresenterInterface $presenter = null): DatatableInteractorInterface
    {
        return new DatatableInteractor($datatable, $presenter);
    }
}
