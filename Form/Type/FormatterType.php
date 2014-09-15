<?php

/*
 * This file is part of the RzFormatterBundle package.
 *
 * (c) mell m. zamora <mell@rzproject.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rz\FormatterBundle\Form\Type;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;

use Sonata\FormatterBundle\Formatter\Pool;



use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

use Symfony\Component\Form\AbstractType;

use Ivory\CKEditorBundle\Model\ConfigManagerInterface;

use Sonata\FormatterBundle\Form\EventListener\FormatterListener;

class FormatterType extends AbstractTypeExtension
{
    protected $pool;
    protected $ckeditorConfigManager;
    protected $translator;

    /**
     * @param \Sonata\FormatterBundle\Formatter\Pool             $pool
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     */
    public function __construct(Pool $pool, TranslatorInterface $translator, $ckeditorConfigManager)
    {
        $this->pool = $pool;
        $this->translator = $translator;
        $this->ckeditorConfigManager = $ckeditorConfigManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {

        if (is_array($options['source_field'])) {
            list($sourceField, ) = $options['source_field'];
            $view->vars['source_field'] = $sourceField;
        } else {
            $view->vars['source_field'] = $options['source_field'];
        }

        if (is_array($options['format_field'])) {
            list($formatField, ) = $options['format_field'];
            $view->vars['format_field'] = $formatField;
        } else {
            $view->vars['format_field'] = $options['format_field'];
        }
        $view->vars['format_field_options'] = $options['format_field_options'];

        $ckeditorConfiguration = array(
            'toolbar'       => array_values($options['ckeditor_toolbar_icons']),
        );

        if ($options['ckeditor_context']) {
            $contextConfig = $this->configManager->getConfig($options['ckeditor_context']);
            $ckeditorConfiguration = array_merge($ckeditorConfiguration, $contextConfig);
        }



        $ckeditorConfiguration = array_merge($ckeditorConfiguration, $options['ckeditor_config']);

        $view->vars['ckeditor_configuration'] = $ckeditorConfiguration;
        $view->vars['ckeditor_basepath'] = $options['ckeditor_basepath'];

        $view->vars['source_id'] = str_replace($view->vars['name'], $view->vars['source_field'], $view->vars['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {


        $pool = $this->pool;
        $translator = $this->translator;

        $resolver->setOptional(array('selectpicker_enabled',
                                   'selectpicker_data_style',
                                   'selectpicker_title',
                                   'selectpicker_selected_text_format',
                                   'selectpicker_show_tick',
                                   'selectpicker_data_width',
                                   'selectpicker_data_size',
                                   'selectpicker_disabled',
                                   'selectpicker_dropup',
                                   'ckeditor_config')
        );

        $resolver->setDefaults(array(
                   'inherit_data'      => true,
                   'event_dispatcher'  => null,
                   'format_field'      => null,
                   'format_field_options' => array(
                       'choices'           => function (Options $options) use ($pool, $translator) {
                           $formatters = array();
                           foreach ($pool->getFormatters() as $code => $instance) {
                               $formatters[$code] = $translator->trans($code, array(), 'SonataFormatterBundle');
                           }

                           return $formatters;
                       }
                   ),
                   'source_field' => null,
                   'source_field_options'      => array(
                       'attr' => array('class' => 'span10', 'rows' => 20)
                   ),
                   'target_field' => null,
                   'listener'     => true,
                   'selectpicker_enabled' => false,
                   'ckeditor_config'=> $this->ckeditorConfigManager->getConfig('default')


        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'sonata_formatter_type';
    }
}
