<?php declare(strict_types=1);

namespace Palmyr\SymfonyAws\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('palmyr_aws');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('sdk')
                    ->children()
                        ->scalarNode('version')->defaultValue("latest")->end()
                    ->end() // sdk children
                ->end() // sdk
            ->end()
        ;

        return $treeBuilder;
    }


}