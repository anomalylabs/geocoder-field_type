<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAccessor;

/**
 * Class GeocoderFieldTypeAccessor
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\GeocoderFieldType
 */
class GeocoderFieldTypeAccessor extends FieldTypeAccessor
{

    /**
     * Desired data properties.
     *
     * @var array
     */
    protected $properties = [
        'address',
        'formatted',
        'latitude',
        'longitude',
        'marker_latitude',
        'marker_longitude'
    ];

    /**
     * Set the value.
     *
     * @param $value
     * @return array
     */
    public function set($value)
    {
        $entry = $this->fieldType->getEntry();

        $attributes = $entry->getAttributes();

        if (is_array($value)) {
            foreach ($this->properties as $property) {
                $attributes[$this->fieldType->getColumnName() . '_' . $property] = array_pull($value, $property);
            }
        }

        if (is_null($value)) {
            foreach ($this->properties as $property) {
                $attributes[$this->fieldType->getColumnName() . '_' . $property] = $value;
            }
        }

        $entry->setRawAttributes($attributes);
    }

    /**
     * Get the value.
     *
     * @return array
     */
    public function get()
    {
        $entry = $this->fieldType->getEntry();

        $attributes = $entry->getAttributes();
        
        return array_combine(
            $this->properties,
            array_map(
                function ($property) use ($attributes) {
                    return array_get($attributes, $this->fieldType->getColumnName() . '_' . $property);
                },
                $this->properties
            )
        );
    }
}
