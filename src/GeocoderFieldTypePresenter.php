<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Image\Image;
use Collective\Html\HtmlBuilder;

/**
 * Class GeocoderFieldTypePresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\GeocoderFieldType
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
     * The image utility.
     *
     * @var Image
     */
    protected $image;

    /**
     * Create a new GeocoderFieldTypePresenter instance.
     *
     * @param HtmlBuilder $html
     * @param Image       $image
     * @param             $object
     */
    public function __construct(HtmlBuilder $html, Image $image, $object)
    {
        $this->html  = $html;
        $this->image = $image;

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
            'center'         => $this->position($formatted),
            'scale'          => array_get($options, 'scale', 1),
            'zoom'           => $this->object->config('zoom', 13),
            'format'         => array_get($options, 'format', 'png'),
            'maptype'        => array_get($options, 'maptype', 'roadmap'),
            'visual_refresh' => array_get($options, 'visual_refresh', true),
            'size'           => array_get($options, 'width', 150) . 'x' . array_get($options, 'height', 100)
        ];

        $marker = array_get($options, 'marker');

        $color = 'color:0xfa5b4a';
        $size  = 'size:' . array_get($marker, 'marker', 'small');
        $label = 'label:' . array_get($marker, 'label', 'A') . '|' . $this->position($formatted);

        $data['markers'] = implode('|', [$size, $color, $label]);

        $url = 'http://maps.googleapis.com/maps/api/staticmap?'
            . http_build_query($data)
            . '&key=' . $this->object->key();

        return $this->image->make($url, 'image')->setExtension(array_get($options, 'format', 'png'));
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
        return 'https://www.google.com/maps/place/' . $this->position($formatted) . '/';
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

        return implode(',', [$latitude, $longitude]);
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
