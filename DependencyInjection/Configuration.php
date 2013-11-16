<?php

namespace Spomky\IpFilterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('spomky_ip_filter');

        $supportedDrivers = array(
            'orm',
        );
        $supportedPolicies = array(
            'blacklist',
            'whitelist',
        );

        $rootNode
            ->children()

                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of ' . json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()

                ->scalarNode('policy')
                    ->validate()
                        ->ifNotInArray($supportedPolicies)
                        ->thenInvalid('The policy %s is not supported. Please choose one of ' . json_encode($supportedPolicies))
                    ->end()
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()

                ->scalarNode('ip_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('ip_manager')->defaultValue('spomky_ip_filter.ip_manager.default')->end()

                ->scalarNode('range_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('range_manager')->defaultValue('spomky_ip_filter.range_manager.default')->end()
            ->end();

        return $treeBuilder;
    }
}
