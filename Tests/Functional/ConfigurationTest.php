<?php

namespace Spomky\IpFilterBundle\Tests\Functional;

use Matthias\SymfonyConfigTest\PhpUnit\AbstractConfigurationTestCase;
use Spomky\IpFilterBundle\DependencyInjection\Configuration;

class ConfigurationTest extends AbstractConfigurationTestCase
{
    protected function getConfiguration()
    {
        return new Configuration('alias');
    }

    public function testAlias()
    {
        $tree = $this->getConfiguration()->getConfigTreeBuilder();
        $this->assertEquals('alias', $tree->buildTree()->getName());
    }

    /**
     * @dataProvider dataValuesAreInvalidIfRequiredValueIsNotProvided
     */
    public function testValuesAreInvalidIfRequiredValueIsNotProvided($config, $message)
    {
        $this->assertConfigurationIsInvalid(
            $config,
            $message
        );
    }

    public function dataValuesAreInvalidIfRequiredValueIsNotProvided()
    {
        return array(
            array(
                array(
                    array(),
                ),
                'The child node "db_driver" at path "alias" must be configured.',
            ),
            array(
                array(
                    array('db_driver' => 'data'),
                ),
                'Invalid configuration for path "alias.db_driver": The driver "data" is not supported. Please choose one of ["orm"]',
            ),
            array(
                array(
                    array('db_driver' => 'orm'),
                ),
                'The child node "ip_class" at path "alias" must be configured.',
            ),
            array(
                array(
                    array('db_driver' => 'orm'),
                    array('ip_class' => 'my_ip_class'),
                ),
                'The child node "range_class" at path "alias" must be configured.',
            ),
        );
    }

    /**
     * @dataProvider dataProcessedValueContainsRequiredValue
     */
    public function testProcessedValueContainsRequiredValue($config, $data)
    {
        $this->assertProcessedConfigurationEquals(
            $config,
            $data
        );
    }

    public function dataProcessedValueContainsRequiredValue()
    {
        return array(
            array(
                array(
                    array('db_driver' => 'orm'),
                    array('ip_class' => 'my_ip_class'),
                    array('range_class' => 'my_range_class'),
                ),
                array(
                    'db_driver' => 'orm',
                    'ip_class' => 'my_ip_class',
                    'range_class' => 'my_range_class',
                    'ip_manager' => 'spomky_ip_filter.ip_manager.default',
                    'range_manager' => 'spomky_ip_filter.range_manager.default',

                ),
            ),
            array(
                array(
                    array('db_driver' => 'orm'),
                    array('ip_class' => 'my_ip_class'),
                    array('range_class' => 'my_range_class'),
                    array('ip_manager' => 'my_ip_manager'),
                    array('range_manager' => 'my_range_manager'),
                ),
                array(
                    'db_driver' => 'orm',
                    'ip_class' => 'my_ip_class',
                    'range_class' => 'my_range_class',
                    'ip_manager' => 'my_ip_manager',
                    'range_manager' => 'my_range_manager',

                ),
            ),
        );
    }
}
