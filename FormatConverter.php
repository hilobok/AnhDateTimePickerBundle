<?php

namespace Anh\DateTimePickerBundle;

class FormatConverter
{
    /**
     * Holds map for intl to javascript date format conversion.
     */
    protected $intlToJsDateMap = array(
        'DD' => 'oo',
        'D' => 'o',
        'EEEE' => 'DD',
        'EEE' => 'D',
        'MM' => 'mm',
        'M' => 'm',
        'MMMM' => 'MM',
        'MMM' => 'M',
        'yyyy' => 'yy',
        'yy' => 'y',
        'YYYY' => 'yy',
        'YY' => 'y',
    );

    /**
     * Holds map for intl to javascript time format conversion.
     */
    protected $intlToJsTimeMap = array(
        'S' => 'l',
        'zzz' => 'z',
        'zz' => 'z',
        'ZZZZZ' => 'Z'
    );

    /**
     * Converts date format from intl to javascript
     */
    public function intlToJsDateFormat($format)
    {
        return $this->convert($format, $this->intlToJsDateMap);
    }

    /**
     * Converts time format from intl to javascript
     */
    public function intlToJsTimeFormat($format)
    {
        return $this->convert($format, $this->intlToJsTimeMap);
    }

    /**
     * Converts format using given map
     *
     * @param string $format
     * @param array  $map
     *
     * @return string
     */
    protected function convert($format, $map)
    {
        if (empty($format)) {
            return '';
        }

        $parts = explode("'", $format);

        if (!count($parts) % 2) {
            throw new \InvalidArgumentException("Unpaired quote in '{$format}'.");
        }

        for ($i = 0; $i < count($parts); $i++) {
            // skip parts in quotes
            if (!($i % 2)) {
                $chunks = $this->split($parts[$i]);

                foreach ($chunks as &$chunk) {
                    if (isset($map[$chunk])) {
                        $chunk = $map[$chunk];
                    }
                }

                $parts[$i] = implode('', $chunks);
            }
        }

        return implode("'", $parts);
    }

    /**
     * Splits given string into chunks.
     * 'yyyy-mm-dd' splits into [ 'yyyy', '-', 'mm', '-', 'dd' ]
     *
     * @param string $string
     *
     * @return array
     */
    protected function split($string)
    {
        $result = array();

        if (empty($string)) {
            return $result;
        }

        $chunk = $prev = $string[0];

        for ($i = 1; $i < strlen($string); $i++) {
            if ($prev === $string[$i]) {
                $chunk .= $string[$i];
            } else {
                $result[] = $chunk;
                $prev = $chunk = $string[$i];
            }
        }

        if (!empty($chunk)) {
            $result[] = $chunk;
        }

        return $result;
    }
}
