<?php

namespace TranslateFileManager\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        if (\method_exists(TreeBuilder::class, 'getRootNode')) {
            $treeBuilder = new TreeBuilder('translate_file_manager');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('translate_file_manager');
        }

        $rootNode
            ->children()
            ->booleanNode('enable')->defaultTrue()->end()
            ->booleanNode('async')->defaultFalse()->end()
            ->booleanNode('auto_inline')->defaultTrue()->end()
            ->booleanNode('inline')->defaultFalse()->end()
            ->booleanNode('autoload')->defaultTrue()->end()
            ->booleanNode('jquery')->defaultFalse()->end()
            ->booleanNode('require_js')->defaultFalse()->end()
            ->booleanNode('input_sync')->defaultFalse()->end()
            ->scalarNode('base_path')->defaultValue('bundles/fosckeditor/')->end()
            ->scalarNode('js_path')->defaultValue('bundles/fosckeditor/ckeditor.js')->end()
            ->scalarNode('jquery_path')->defaultValue('bundles/fosckeditor/adapters/jquery.js')->end()
            ->scalarNode('default_config')->defaultValue(null)->end()
            ->append($this->createConfigsNode())
            ->end();

        return $treeBuilder;
    }

    private function createConfigsNode(): ArrayNodeDefinition
    {
        return $this->createPrototypeNode('configs')
            ->arrayPrototype()
            ->normalizeKeys(false)
            ->useAttributeAsKey('name')
            ->variablePrototype()->end()
            ->end();
    }

    private function createPrototypeNode(string $name): ArrayNodeDefinition
    {
        return $this->createNode($name)
            ->normalizeKeys(false)
            ->useAttributeAsKey('name');
    }

    private function createNode(string $name): ArrayNodeDefinition
    {
        if (\method_exists(TreeBuilder::class, 'getRootNode')) {
            $treeBuilder = new TreeBuilder($name);
            $node = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $treeBuilder = new TreeBuilder();
            $node = $treeBuilder->root($name);
        }

        \assert($node instanceof ArrayNodeDefinition);

        return $node;
    }
}
