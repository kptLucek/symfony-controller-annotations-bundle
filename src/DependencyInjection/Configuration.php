<?php

namespace Lucek\ControllerAnnotationReaderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Lucek\ControllerAnnotationReaderBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('controller_annotation_reader');
        $rootNode    = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
