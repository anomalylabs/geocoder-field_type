<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\GeocoderFieldType\Spatial\Point;

/**
 * Class GeocoderFieldTypePoint
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GeocoderFieldTypePoint
{

    /**
     * The address result.
     *
     * @var array
     */
    protected $result;

    /**
     * Create a new GeocoderFieldTypePoint instance.
     *
     * @param array $result
     */
    public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * Get the result.
     *
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Return the original address.
     *
     * @return string|null
     */
    public function address()
    {
        return array_get($this->result, 'address');
    }

    /**
     * Return the formatted address.
     *
     * @return string|null
     */
    public function formatted()
    {
        return array_get($this->result, 'formatted_address');
    }

    /**
     * Return an address component.
     *
     * @param $type
     * @return null|array
     */
    public function component($type)
    {
        foreach ($this->result['address_components'] as $component) {
            if (in_array($type, $component['types'])) {
                return $component;
            }
        }

        return null;
    }

    /**
     * Return a component name.
     *
     * @param        $component
     * @param string $type
     * @return string|null
     */
    public function componentValue($component, $type = 'long')
    {
        return array_get((array)$this->component($component), $type . '_name');
    }

    /**
     * Return the route.
     *
     * @return string|null
     */
    public function route()
    {
        return $this->componentValue('route');
    }

    /**
     * Return the street number.
     *
     * @return string|null
     */
    public function streetNumber()
    {
        return $this->componentValue('street_number');
    }

    /**
     * Return the street address.
     *
     * @return string|null
     */
    public function streetAddress()
    {
        return $this->componentValue('street_number') . ' ' . $this->componentValue('route');
    }

    /**
     * Return the neighborhood.
     *
     * @return string|null
     */
    public function neighborhood()
    {
        return $this->componentValue('neighborhood');
    }
    
    /**
     * Return the city.
     *
     * @return string|null
     */
    public function city()
    {
        return $this->componentValue('locality');
    }
    
    /**
     * Alias for postalCode().
     *
     * @return string|null
     */
    public function zip()
    {
        return $this->postalCode();
    }

    /**
     * Return the postal code.
     *
     * @return string|null
     */
    public function postalCode()
    {
        return $this->componentValue('postal_code');
    }

    /**
     * Return the state.
     *
     * @return string|null
     */
    public function state()
    {
        return $this->componentValue('administrative_area_level_1');
    }

    /**
     * Return the state code.
     *
     * @return string|null
     */
    public function stateCode()
    {
        return $this->componentValue('administrative_area_level_1', 'short');
    }

    /**
     * Return the county.
     *
     * @return string|null
     */
    public function county()
    {
        return $this->componentValue('administrative_area_level_2');
    }

    /**
     * Return the country.
     *
     * @return string|null
     */
    public function country()
    {
        return $this->componentValue('country');
    }

    /**
     * Return the country code.
     *
     * @return string|null
     */
    public function countryCode()
    {
        return $this->componentValue('country', 'short');
    }

    /**
     * Return the location.
     *
     * @return array
     */
    public function location()
    {
        return array_get($this->result, 'geometry.location');
    }

    /**
     * Return the latitude.
     *
     * @return float|null
     */
    public function latitude()
    {
        return array_get((array)$this->location(), 'lat');
    }

    /**
     * Return the longitude.
     *
     * @return float|null
     */
    public function longitude()
    {
        return array_get((array)$this->location(), 'lng');
    }

    /**
     * Return a new geometric point interface.
     *
     * @return Point
     */
    public function point()
    {
        return new Point($this->latitude(), $this->longitude());
    }

    /**
     * Return data for storage.
     *
     * @return array
     */
    public function storage()
    {
        return [
            'address'             => $this->address(),
            'formatted'           => $this->formatted(),
            'latitude'            => $this->latitude(),
            'longitude'           => $this->longitude(),
            'formatted_latitude'  => $this->latitude(),
            'formatted_longitude' => $this->longitude(),
        ];
    }
}
