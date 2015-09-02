<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeModifier;

/**
 * Class GeocoderFieldTypeModifier
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\GeocoderFieldType
 */
class GeocoderFieldTypeModifier extends FieldTypeModifier
{

    /**
     * Modify the value.
     *
     * @param $value
     * @return string
     */
    public function modify($value)
    {
        return serialize((array)$value);
    }

    /**
     * Restore the value.
     *
     * @param $value
     * @return array
     */
    public function restore($value)
    {
        if (!$value) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        return (array)unserialize($value);
    }
}
