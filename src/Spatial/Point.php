<?php namespace Anomaly\GeocoderFieldType\Spatial;

/**
 * Class Point
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Point
{

    /**
     * The latitude value.
     *
     * @var float
     */
    protected $latitude;

    /**
     * The longitude value.
     *
     * @var float
     */
    protected $longitude;

    /**
     * Create a new Point instance.
     *
     * @param $latitude
     * @param $longitude
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude  = (float)$latitude;
        $this->longitude = (float)$longitude;
    }

    /**
     * Return the text for spatial queries.
     *
     * @return string
     */
    public function text()
    {
        return sprintf('POINT(%s)', $this->longitude . ' ' . $this->latitude);
    }
}
