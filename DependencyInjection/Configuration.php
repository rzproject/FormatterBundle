<?php

namespace Rz\FormatterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('rz_formatter');
        $this->addAdminSection($node);
        return $treeBuilder;
    }

    private function addAdminSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('admin_extenstion')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('ckeditor')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('Rz\\FormatterBundle\\Admin\\CkeditorAdminExtension')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
