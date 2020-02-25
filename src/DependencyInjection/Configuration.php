<?php

namespace Yoeunes\Notify\Toastr\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('notify_toastr');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('scripts')
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('styles')
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('options')
                    ->ignoreExtraKeys(false)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}