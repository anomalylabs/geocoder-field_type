<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAccessor;
use Anomaly\GeocoderFieldType\Spatial\Point;
use Illuminate\Database\Connection;

/**
 * Class GeocoderFieldTypeAccessor
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
        'formatted_latitude',
        'formatted_longitude',
    ];

    /**
     * The field type instance.
     *
     * @var GeocoderFieldType
     */
    protected $fieldType;

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

            /**
             * If the spatial library is installed
             * then use the lat/long for the points.
             */
            if ($this->fieldType->isSpatialEnabled()) {

                /* @var Connection $connection */
                $connection = app('db')->connection();

                $attributes[$this->fieldType->getColumnName() . '_point'] = $connection->raw(
                    sprintf(
                        "GeomFromText('%s')",
                        (new Point(
                            array_get($attributes, $this->fieldType->getColumnName() . '_latitude'),
                            array_get($attributes, $this->fieldType->getColumnName() . '_longitude')
                        ))->text()
                    )
                );

                $attributes[$this->fieldType->getColumnName() . '_formatted_point'] = $connection->raw(
                    sprintf(
                        "GeomFromText('%s')",
                        (new Point(
                            array_get($attributes, $this->fieldType->getColumnName() . '_formatted_latitude'),
                            array_get($attributes, $this->fieldType->getColumnName() . '_formatted_longitude')
                        ))->text()
                    )
                );
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
        $entry  = $this->fieldType->getEntry();
        $prefix = $this->fieldType->getColumnName();

        $attributes = $entry->getAttributes();

        return array_combine(
            $this->properties,
            array_map(
                function ($property) use ($attributes, $prefix) {
                    return array_get($attributes, $prefix . '_' . $property);
                },
                $this->properties
            )
        );
    }
}
