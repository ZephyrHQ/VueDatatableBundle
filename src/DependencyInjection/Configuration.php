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
        $rootNode = $tree->root('vue_datatable');
        $rootNode
            ->children()
                ->scalarNode('vue_table2_route_name')->isRequired()->end()
        ;

        return $tree;
    }
}
