<?php

declare(strict_types=1);

namespace VueDatatableBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use VueDatatableBundle\Presenter\VueTable2Presenter;

/**
 * Class VueDatatableExtension.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class VueDatatableExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        if ($configuration === null) {
            throw new RuntimeException('Configuration not found for VueDatatableBridgeBundle');
        }
        $config = $this->processConfiguration($configuration, $configs);

        $container->findDefinition(VueTable2Presenter::class)->setArgument('$routeName', $config['vue_table2_route_name']);
    }
}
