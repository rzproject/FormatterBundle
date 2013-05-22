<?php


namespace Rz\FormatterBundle\Form\Type;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;

use Sonata\FormatterBundle\Form\EventListener\FormatterListener;

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
            'source' => function (Options $options, $previousValue) {
                if ($options['listener'] && !$previousValue) {
                    throw new \RuntimeException('Please provide a source property name');
                }

                return null;
            },
            'target' => function (Options $options, $previousValue) {
                if ($options['listener'] && !$previousValue) {
                    throw new \RuntimeException('Please provide a target property name');
                }

                return null;
            },
            'listener' => false,
            'choices' => function (Options $options) use ($pool, $translator) {
                $formatters = array();
                foreach ($pool->getFormatters() as $code => $instance) {
                    $formatters[$code] = $translator->trans($code, array(), 'SonataFormatterBundle');
                }

                return $formatters;
            },
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
