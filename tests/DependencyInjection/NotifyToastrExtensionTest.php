<?php

namespace DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Yoeunes\Notify\Config\ConfigInterface;
use Yoeunes\Notify\Symfony\DependencyInjection\NotifyExtension;
use Yoeunes\Notify\Symfony\NotifyBundle;
use Yoeunes\Notify\Toastr\Symfony\DependencyInjection\NotifyToastrExtension;
use Yoeunes\Notify\Toastr\Symfony\NotifyToastrBundle;

final class NotifyToastrExtensionTest extends TestCase
{
    public function testContainContainNotifyService()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('notify_toastr', array());
        $container->compile();

        $this->assertTrue($container->has('notify'));
        $this->assertTrue($container->has('notify.toastr'));
    }

    public function test_notify_manager_get_config()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('notify_toastr', array(
            'scripts' => array('jquery.js', 'notify.js'),
            'styles' => array('bootstrap.css', 'notify.css'),
            'options' => array()
        ));
        $container->compile();

        $definition = $container->getDefinition('notify');
        /** @var ConfigInterface $config */
        $config = $definition->getArgument(0);

        $this->assertInstanceOf('Yoeunes\Notify\Config\ConfigInterface', $config);
        $this->assertEquals(array('notifier' => 'toastr', 'scripts' => array('jquery.js', 'notify.js'),
            'styles' => array('bootstrap.css', 'notify.css'),
            'options' => array()), $config->get('notifiers.toastr'));
    }

    private function getRawContainer()
    {
        $container = new ContainerBuilder();

        $notifyExtension = new NotifyExtension();
        $container->registerExtension($notifyExtension);

        $notifyBundle = new NotifyBundle();
        $notifyBundle->build($container);

        $toastrExtension = new NotifyToastrExtension();
        $container->registerExtension($toastrExtension);

        $toastrBundle = new NotifyToastrBundle();
        $toastrBundle->build($container);


        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->getCompilerPassConfig()->setAfterRemovingPasses(array());


        $container->loadFromExtension('notify', array());

        return $container;
    }

    private function getContainer()
    {
        $container = $this->getRawContainer();
        $container->compile();

        return $container;
    }
}
