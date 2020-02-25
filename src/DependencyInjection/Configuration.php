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
                    ->defaultValue([
                        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
                        'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js',
                    ])
                ->end()
                ->arrayNode('styles')
                    ->scalarPrototype()->end()
                    ->defaultValue([
                        'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css',
                        'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css'
                    ])
                ->end()
                ->arrayNode('options')
                    ->ignoreExtraKeys(false)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
