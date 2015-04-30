<?php

namespace Rz\FormatterBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\FormatterBundle\Block\FormatterBlockService as BaseFormatterBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author     Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class FormatterBlockService extends BaseFormatterBlockService
{
    protected $templates;

    /**
     * @return mixed
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * @param mixed $templates
     */
    public function setTemplates($templates)
    {
        $this->templates = $templates;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderResponse($this->getTemplating()->exists($blockContext->getTemplate()) ? $blockContext->getTemplate() : 'RzFormatterBundle:Block:block_formatter.html.twig',
            array('block'     => $blockContext->getBlock(),
                  'settings'  => $blockContext->getSettings()
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        if($this->getTemplates()) {
            $keys[] = array('template', 'choice', array('choices'=>$this->getTemplates()));
        }
        $keys[] = array('content', 'sonata_formatter_type', function(FormBuilderInterface $formBuilder) {
                            return array(
                                'event_dispatcher' => $formBuilder->getEventDispatcher(),
                                'format_field'     => array('format', '[format]'),
                                'source_field'     => array('rawContent', '[rawContent]'),
                                'target_field'     => '[content]'
                            );
                        });
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => $keys
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'format'     => 'richhtml',
            'rawContent' => '<b>Insert your custom content here</b>',
            'content'    => '<b>Insert your custom content here</b>',
            'template'   => 'RzFormatterBundle:Block:block_formatter.html.twig'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Text - (WYSIWIG Rich Text Area)';
    }

}
