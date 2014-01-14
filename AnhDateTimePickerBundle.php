<?php

namespace Anh\DateTimePickerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AnhDateTimePickerBundle extends Bundle
{
    public static function getRequiredBundles()
    {
        return array(
            'Sp\BowerBundle\SpBowerBundle',
        );
    }
}
