<?php

namespace VueDatatableBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use VueDatatableBundle\DependencyInjection\Compiler\TypePass;

/**
 * Class VueDatatableBundle.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class VueDatatableBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new TypePass());
    }
}
