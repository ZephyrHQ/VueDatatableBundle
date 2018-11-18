<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain\Provider;

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
    public function format(callable $formatter);
}
