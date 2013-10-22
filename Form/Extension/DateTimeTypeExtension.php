<?php

namespace Anh\Bundle\DateTimePickerBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;

use Anh\Bundle\DateTimePickerBundle\FormatConverter;

class DateTimeTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritDoc}
     */
    public function getExtendedType()
    {
        return 'datetime';
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'picker',
            'separator'
        ));
        $resolver->setDefaults(array(
            'widget' => 'single_text',
            'separator' => "'T'"
        ));
        $resolver->setNormalizers(array(
            'picker' => function(Options $options, $value) {
                if (empty($value) or $options['widget'] !== 'single_text') {
                    return;
                }

                if (!is_array($value)) {
                    $value = array();
                }

                list($dateFormat, $timeFormat) = explode(
                    $options['separator'],
                    $options['format'],
                    2
                ) + array('', '');

                if (empty($dateFormat) or empty($timeFormat)) {
                    throw new \InvalidArgumentException(
                        "Unable to parse date and time format in '{$options['format']}'. Ensure 'separator' option is set properly."
                    );
                }

                $converter = new FormatConverter();

                return array(
                    'dateFormat' => $converter->intlToJsDateFormat($dateFormat),
                    'timeFormat' => $converter->intlToJsTimeFormat($timeFormat),
                    'separator' => str_replace("'", '', $options['separator'])
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

        $view->vars['attr']['data-pickertype'] = 'datetime';
        $view->vars['attr']['data-picker'] = json_encode($options['picker']);
    }
}
