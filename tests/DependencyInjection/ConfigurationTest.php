<?php

namespace Notify\Symfony\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Notify\Symfony\Toastr\DependencyInjection\Configuration;

final class ConfigurationTest extends TestCase
{
    public function test_default_config()
    {
        $config = $this->process(array());

        $this->assertEquals(array(
            'notifier' => 'toastr',
            'scripts' => array(
                'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js',
            ),
            'styles' => array(
                'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css',
            ),
        ), $config);
    }

    public function test_override_config()
    {
        $config = $this->process(array(array(
            'scripts' => array(
                'jquery.min.js',
            ),
        )));

        $this->assertEquals(array(
            'notifier' => 'toastr',
            'scripts' => array(
                'jquery.min.js',
            ),
            'styles' => array(
                'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css',
            ),
        ), $config);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function test_invalid_configuration()
    {
        $this->process(array(array('default' => '')));
    }

    /**
     * Processes an array of configurations and returns a compiled version.
     *
     * @param array $configs An array of raw configurations
     *
     * @return array A normalized array
     */
    private function process($configs)
    {
        $processor = new Processor();

        return $processor->processConfiguration(new Configuration(), $configs);
    }
}
