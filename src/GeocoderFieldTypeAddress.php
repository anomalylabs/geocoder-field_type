<?php namespace Anomaly\GeocoderFieldType;

/**
 * Class GeocoderFieldTypeAddress
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GeocoderFieldTypeAddress
{

    /**
     * The address result.
     *
     * @var array
     */
    protected $result;

    /**
     * Create a new GeocoderFieldTypeAddress instance.
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
    protected function componentValue($component, $type = 'long')
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
     * Return the street address.
     *
     * @return string|null
     */
    public function streetAddress()
    {
        return $this->componentValue('street_number') . ' ' . $this->componentValue('route');
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
