<?php

declare(strict_types=1);

namespace VueDatatableBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use VueDatatableBundle\Domain\Type\DatatableTypeRegistry;

class TypePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $types = [];
        foreach ($container->findTaggedServiceIds('vue_datatable.type') as $id => $tags) {
            $types[$id] = new Reference($id);
        }

        $registry = $container->findDefinition(DatatableTypeRegistry::class);
        $registry->setArgument(0, ServiceLocatorTagPass::register($container, $types));
    }
}
