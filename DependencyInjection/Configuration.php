<?php

namespace Mojo\Sonata\UIBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface {

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mojo_sonata_ui');


        
        
        $rootNode
            ->children()
                ->arrayNode('menu')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('pages')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('route')->end()
                                        ->arrayNode('pages')
                                            ->prototype('array')
                                                ->children()
                                                    ->scalarNode('route')->end()
                                                ->end()
                                             ->end()
                                        ->end()                
                                    ->end()
                                 ->end()
                            ->end()
                            ->arrayNode('options')
                                ->children()
                                    ->scalarNode('class')->end()
                                ->end()    
                            ->end()                
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;    
        
        
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }


}
