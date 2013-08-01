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

class FormatterType extends AbstractTypeExtension
{
    protected $pool;

    protected $translator;

    /**
     * @param \Sonata\FormatterBundle\Formatter\Pool             $pool
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     */
    public function __construct(Pool $pool, TranslatorInterface $translator)
    {
        $this->pool = $pool;
        $this->translator = $translator;
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
                                   'selectpicker_dropup')
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
            'selectpicker_enabled' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'sonata_formatter_type_selector';
    }
}
