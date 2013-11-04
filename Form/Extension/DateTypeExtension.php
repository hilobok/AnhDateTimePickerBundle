<?php

namespace Anh\DateTimePickerBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;

use Anh\DateTimePickerBundle\FormatConverter;

class DateTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritDoc}
     */
    public function getExtendedType()
    {
        return 'date';
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

                return array(
                    'dateFormat' => $converter->intlToJsDateFormat($options['format'])
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

        $view->vars['attr']['data-pickertype'] = 'date';
        $view->vars['attr']['data-picker'] = json_encode($options['picker']);
    }
}
