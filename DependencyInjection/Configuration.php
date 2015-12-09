<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

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
     * {@inheritdoc}
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
