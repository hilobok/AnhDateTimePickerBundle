<?php

namespace Anh\Bundle\DateTimePickerBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;

use Anh\Bundle\DateTimePickerBundle\FormatConverter;

class TimeTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritDoc}
     */
    public function getExtendedType()
    {
        return 'time';
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'picker'
        ));
        $resolver->setDefaults(array(
            'widget' => 'single_text'
        ));
        $resolver->setNormalizers(array(
            'picker' => function(Options $options, $value) {
                if (empty($value) or $options['widget'] !== 'single_text') {
                    return;
                }

                if (!is_array($value)) {
                    $value = array();
                }

                $converter = new FormatConverter();

                $format = $options['with_seconds'] ? 'HH:mm:ss' : 'HH:mm';

                return array(
                    'timeOnly' => true,
                    'timeFormat' => $converter->intlToJsDateFormat($format)
                ) + $value;
            }
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (empty($options['picker'])) {
            return;
        }

        $view->vars['attr']['data-pickertype'] = 'time';
        $view->vars['attr']['data-picker'] = json_encode($options['picker']);
    }
}
