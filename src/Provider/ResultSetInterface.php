<?php

declare(strict_types=1);

namespace VueDatatableBundle\Provider;

/**
 * Interface ResultSetInterface.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
interface ResultSetInterface
{
    public function getTotal(): int;
    public function getDisplayedTotal(): int;
    public function getData(): \Iterator;
}
