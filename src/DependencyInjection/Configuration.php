<?php

namespace VueDatatableBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $tree = new TreeBuilder();
        $rootNode = $tree->root('vue_datatable_bridge');
        $rootNode
            ->children()
                ->scalarNode('toto')->defaultNull()->end()
        ;

        return $tree;
    }
}
