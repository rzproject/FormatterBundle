<?php

namespace Rz\FormatterBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        #####################################
        ## Override Admin Extension
        #####################################
        $definition = $container->getDefinition('sonata.formatter.ckeditor.extension');
        $definition->setClass($container->getParameter('rz.formatter.admin_extenstion.media.class'));
    }
}
