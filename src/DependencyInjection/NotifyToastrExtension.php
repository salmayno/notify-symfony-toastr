<?php

namespace Notify\Symfony\Toastr\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class NotifyToastrExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $toastrRenderer = $container->getDefinition('notify.renderer.toastr');
        $toastrRenderer->replaceArgument(0, isset($config['scripts']) ? $config['scripts'] : []);
        $toastrRenderer->replaceArgument(1, isset($config['styles']) ? $config['styles'] : []);
        $toastrRenderer->replaceArgument(2, isset($config['options']) ? $config['options'] : []);
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        if (!$container->hasExtension('notify')) {
            throw new \RuntimeException('[Notify\Symfony\NotifyBundle] is not registered');
        }

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->prependExtensionConfig('notify', array(
            'adapters' => array(
                'toastr' => $config,
            ),
        ));
    }
}
