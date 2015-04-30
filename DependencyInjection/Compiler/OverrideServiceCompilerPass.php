<?php

/*
 * This file is part of the RzBlockBundle package.
 *
 * (c) mell m. zamora <mell@rzproject.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rz\FormatterBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Sonata\AdminBundle\Admin\BaseFieldDescription;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        #################################
        # Override Text Block
        #################################
        $definition = $container->getDefinition('sonata.formatter.block.formatter');
        $definition->setClass($container->getParameter('rz_formatter.block.service.formatter.class'));
        if($container->hasParameter('rz_formatter.block.service.formatter.templates')) {
            $definition->addMethodCall('setTemplates', array($container->getParameter('rz_formatter.block.service.formatter.templates')));
        }
    }
}
