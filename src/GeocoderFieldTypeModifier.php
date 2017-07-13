<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeModifier;

/**
 * Class GeocoderFieldTypeModifier
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GeocoderFieldTypeModifier extends FieldTypeModifier
{

    /**
     * The field type instance.
     *
     * @var GeocoderFieldType
     */
    protected $fieldType;

    /**
     * Create a new GeocoderFieldTypeModifier instance.
     *
     * @param GeocoderFieldType $fieldType
     */
    public function __construct(GeocoderFieldType $fieldType)
    {
        $this->fieldType = $fieldType;
    }

    /**
     * Modify the value for storage.
     *
     * @param $value
     * @return array|mixed
     */
    public function modify($value)
    {
        if (is_string($value)) {

            return $this->fieldType
                ->newGeocoder()
                ->convert($value)
                ->storage();
        }

        return parent::modify($value);
    }
}
