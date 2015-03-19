<?php

namespace SpomkyLabs\IpFilterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private $alias;

    /**
     * @param string $alias
     */
    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->alias);

        $rootNode
            ->children()
                ->scalarNode('ip_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('ip_manager')->defaultValue('sl_ip_filter.ip_manager.default')->end()

                ->scalarNode('range_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('range_manager')->defaultValue('sl_ip_filter.range_manager.default')->end()
            ->end();

        return $treeBuilder;
    }
}
