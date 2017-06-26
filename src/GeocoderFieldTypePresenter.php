<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\GeocoderFieldType\Criteria\EmbedCriteria;
use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Support\Collection;
use Cache;
use Collective\Html\HtmlBuilder;
use Illuminate\Contracts\View\Factory;

/**
 * Class GeocoderFieldTypePresenter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GeocoderFieldTypePresenter extends FieldTypePresenter
{

    /**
     * The decorated object.
     * This is for IDE hinting.
     *
     * @var GeocoderFieldType
     */
    protected $object;

    /**
     * The HTMl builder.
     *
     * @var HtmlBuilder
     */
    protected $html;

    /**
     * The view factory.
     *
     * @var Factory
     */
    protected $view;

    /**
     * The image utility.
     *
     * @var Image
     */
    protected $image;

    /**
     * Create a new GeocoderFieldTypePresenter instance.
     *
     * @param HtmlBuilder $html
     * @param Factory     $view
     * @param Image       $image
     * @param             $object
     */
    public function __construct(HtmlBuilder $html, Factory $view, Image $image, $object, SettingRepositoryInterface $settings)
    {
        $this->html     = $html;
        $this->view     = $view;
        $this->image    = $image;
        $this->settings = $settings;

        parent::__construct($object);
    }

    /**
     * Return a static image map.
     *
     * @param array $options
     * @return null|string
     */
    public function image(array $options = [], $formatted = false)
    {
        if (!$this->object->getValue()) {
            return null;
        }

        $data = [
            'scale'          => array_get($options, 'scale', 1),
            'zoom'           => $this->object->config('zoom', 13),
            'format'         => array_get($options, 'format', 'png'),
            'center'         => implode(',', $this->position($formatted)),
            'maptype'        => array_get($options, 'maptype', 'roadmap'),
            'visual_refresh' => array_get($options, 'visual_refresh', true),
            'size'           => array_get($options, 'width', 150) . 'x' . array_get($options, 'height', 100),
        ];

        $marker = array_get($options, 'marker');

        $color = 'color:0xfa5b4a';
        $size  = 'size:' . array_get($marker, 'marker', 'small');
        $label = 'label:' . array_get($marker, 'label', 'A') . '|' . implode(',', $this->position($formatted));

        $data['markers'] = implode('|', [$size, $color, $label]);

        $url = 'http://maps.googleapis.com/maps/api/staticmap?'
            . http_build_query($data)
            . '&key=' . $this->object->key();

        return $this->image->make($url, 'image')->setExtension(array_get($options, 'format', 'png'));
    }

    /**
     * Return an embed map.
     *
     * @param array $options
     * @param bool  $formatted
     * @return null|string
     */
    public function embed(array $options = [], $formatted = false)
    {
        $criteria = new EmbedCriteria(
            'make',
            function (Collection $options) use ($formatted) {

                return $this->view->make(
                    'anomaly.field_type.geocoder::embed',
                    [
                        'formatted'  => $formatted,
                        'options'    => $options,
                        'field_type' => $this,
                    ]
                )->render();
            }
        );

        $criteria->setOptions($options);

        return $criteria;
    }

    /**
     * Return an embed map for the formatted location.
     *
     * @param array $options
     * @return null|string
     */
    public function formattedEmbed(array $options = [])
    {
        return $this->embed($options, true);
    }

    /**
     * Return a static image map for the formatted location.
     *
     * @param array $options
     * @return null|string
     */
    public function formattedImage(array $options = [])
    {
        return $this->image($options, true);
    }

    /**
     * Return the map URL.
     *
     * @param bool $formatted
     * @return string
     */
    public function url($formatted = false)
    {
        return 'https://www.google.com/maps/place/' . implode(',', $this->position($formatted)) . '/';
    }

    /**
     * Return a link to the URL.
     *
     * @param      $title
     * @param      $attributes
     * @param      $secure
     * @param bool $formatted
     * @return string
     */
    public function link($title, array $attributes = [], $secure = null, $formatted = false)
    {
        return $this->html->link($this->url($formatted), $title ?: $this->url($formatted), $attributes, $secure);
    }

    /**
     * Return a link to the formatted URL.
     *
     * @param      $title
     * @param      $attributes
     * @param      $secure
     * @param bool $formatted
     * @return string
     */
    public function formattedLink($title, array $attributes = [], $secure = null)
    {
        return $this->link($title, $attributes, $secure, true);
    }

    /**
     * Return the marker position.
     *
     * @param bool $formatted
     * @return string
     */
    public function position($formatted = false)
    {
        $latitude  = array_get($this->object->getValue(), $formatted ? 'formatted_latitude' : 'latitude');
        $longitude = array_get($this->object->getValue(), $formatted ? 'formatted_longitude' : 'longitude');

        return compact('latitude', 'longitude');
    }

    /**
     * Return the latitude.
     *
     * @param bool $formatted
     * @return float
     */
    public function latitude($formatted = false)
    {
        return array_get($this->position($formatted), 'latitude');
    }

    /**
     * Return the longitude.
     *
     * @param bool $formatted
     * @return float
     */
    public function longitude($formatted = false)
    {
        return array_get($this->position($formatted), 'longitude');
    }

    /**
     * Revese geocodes the location.
     *
     * @return object
     */
    public function reverseGeocode()
    {
        $minutes = $this->settings->get('anomaly.field_type.geocoder::cache_time')->value; // The cache entry duration in minutes
        $latlng  = $this->latitude() . "," . $this->longitude(); // The format for both the api call and cache entry name
        // Build the url for the api call
        $url     = "https://maps.googleapis.com/maps/api/geocode/json?" .
                   "latlng=" . $latlng .
                   "&key="   . $this->object->key();

        if (Cache::has($latlng)) {
            // If the data that we're looking for is already cached, return that
            return Cache::get($latlng);
        } else {
            // If the data that we're looking for doesn't exist in the cache yet
            // make an api call and extract the first result.
            $json   = file_get_contents($url);
            $object = json_decode($json);
            $data   = $object->results[0];

            // Cache the data
            Cache::put($latlng, $data, $minutes);

            return $data;
        }
    }

    /**
     * Return a address_components from the reverse geocode data
     *
     * @return string
     */
    public function getAddressComponent($component_name, $short_name = false)
    {
        $component          = null;
        $address_components = $this->reverseGeocode()->address_components; // Get all address components

        foreach ($address_components as $address_component) {
            // Loop through all of the adress components
            if (in_array($component_name, $address_component->types)) {
                // If the component contains the name we're looking as type, set is as the component
                $component = $short_name ? $address_component->short_name : $address_component->long_name;
            }
        }

        return $component;
    }

    /**
     * Return the country name
     *
     * @return string
     */
    public function country($short_name = false)
    {
        return $this->getAddressComponent('country', $short_name);
    }

    /**
     * Return the state
     *
     * @return string
     */
    public function state($short_name = false)
    {
        return $this->getAddressComponent('administrative_area_level_1', $short_name);
    }

    /**
     * Return the city name
     *
     * @return string
     */
    public function city($short_name = false)
    {
        return $this->getAddressComponent('locality', $short_name);
    }

    /**
     * Return the street name
     *
     * @return string
     */
    public function street($short_name = false)
    {
        return $this->getAddressComponent('route', $short_name);
    }

    /**
     * Return the street number
     *
     * @return string
     */
    public function street_number($short_name = false)
    {
        return $this->getAddressComponent('street_number', $short_name);
    }

    /**
     * Return the postal code
     *
     * @return string
     */
    public function postal_code($short_name = false)
    {
        return $this->getAddressComponent('postal_code', $short_name);
    }

    /**
     * Return the value key if it exists.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($value = array_get($this->object->getValue(), $key)) {
            return $value;
        }

        return parent::__get($key);
    }
}
