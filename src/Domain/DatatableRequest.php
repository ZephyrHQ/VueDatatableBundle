<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain;

use VueDatatableBundle\Domain\Column\AbstractColumn;

/**
 * Class DatatableRequest.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class DatatableRequest
{
    public const ORDER_ASC = 'asc';
    public const ORDER_DESC = 'desc';

    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $perPage;

    /**
     * @var AbstractColumn
     */
    public $orderBy;

    /**
     * @see self::ORDER_*
     *
     * @var string
     */
    public $orderDir;

    public function __construct(int $page, int $perPage, ?AbstractColumn $orderBy = null, ?string $orderDir = null)
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->orderBy = $orderBy;
        if ($orderDir !== null && \in_array($orderDir, [self::ORDER_ASC, self::ORDER_DESC], true)) {
            $this->orderDir = $orderDir;
        }
    }

//    public $filters;
}
