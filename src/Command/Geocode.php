<?php namespace Anomaly\GeocoderFieldType\Command;

use Anomaly\GeocoderFieldType\GeocoderFieldType;
use Anomaly\GeocoderFieldType\GeocoderFieldTypePoint;

/**
 * Class Geocode
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Geocode
{

    /**
     * The geocoder parameters.
     *
     * @var string|array
     */
    protected $parameters;

    /**
     * Create a new Geocode instance.
     *
     * @param array|string $parameters
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Handle the command.
     *
     * @param GeocoderFieldType $fieldType
     * @return GeocoderFieldTypePoint|null
     */
    public function handle(GeocoderFieldType $fieldType)
    {
        $geocoder = $fieldType->newGeocoder();

        if (is_string($this->parameters)) {
            return $geocoder->convert($this->parameters);
        }

        if (is_array($this->parameters)) {
            return $geocoder->reverse($this->parameters[0], $this->parameters[1]);
        }

        return null;
    }
}
