<?php

namespace Soloist\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('soloist_core');

        $rootNode
            ->children()
                ->arrayNode('node_types')
                    ->useAttributeAsKey('node_type')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('class')->end()
                            ->scalarNode('form_type')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('block_types')
                    ->useAttributeAsKey('block_type')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('class')->end()
                            ->scalarNode('form_type')->end()
                            ->scalarNode('form_template')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('page_types')
                    ->useAttributeAsKey('page_type')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('template')->end()
                            ->scalarNode('admin_template')->end()
                            ->arrayNode('fields')
                                ->useAttributeAsKey('name')
                                ->prototype('variable')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
