<?php namespace Anomaly\GeocoderFieldType\Command;

use Anomaly\GeocoderFieldType\GeocoderFieldTypeGeocoder;
use Grimzy\LaravelMysqlSpatial\Types\Point;

/**
 * Class GetPoint
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GetPoint
{

    /**
     * The point parameters.
     *
     * @var string
     */
    protected $parameters;

    /**
     * Create a new GetPoint instance.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Return a geometric point interface.
     *
     * @param GeocoderFieldTypeGeocoder $geocoder
     * @return Point|null
     */
    public function handle(GeocoderFieldTypeGeocoder $geocoder)
    {
        if (is_array($this->parameters)) {
            return new Point($this->parameters[0], $this->parameters[1]);
        }

        if (is_string($this->parameters)) {
            return $geocoder->convert($this->parameters)->point();
        }

        return null;
    }
}
