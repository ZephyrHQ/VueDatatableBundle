<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain\Presenter;

use Symfony\Component\HttpFoundation\Response;
use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\Provider\ResultSetInterface;

/**
 * Interface DatatablePresenterInterface.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
interface DatatablePresenterInterface
{
    public function createResponse(Datatable $datatable, ResultSetInterface $result): Response;
}
