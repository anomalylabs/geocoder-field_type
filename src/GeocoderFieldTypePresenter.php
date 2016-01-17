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
    public function image(array $options = [])
    {
        if (!$this->object->getValue()) {
            return null;
        }

        $data = [
            'center'         => $this->position(),
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
        $label = 'label:' . array_get($marker, 'label', 'A') . '|' . $this->position();

        $data['markers'] = implode('|', [$size, $color, $label]);

        $url = 'http://maps.googleapis.com/maps/api/staticmap?' . http_build_query($data);

        return $this->image->make($url)->setExtension(array_get($options, 'format', 'png'))->image();
    }

    /**
     * Return the map URL.
     *
     * @return string
     */
    public function url()
    {
        return 'https://www.google.com/maps/place/' . $this->position() . '/';
    }

    /**
     * Return the address.
     *
     * @return double
     */
    public function address()
    {
        return array_get($this->object->getValue(), 'address');
    }

    /**
     * Return the formatted.
     *
     * @return double
     */
    public function formatted()
    {
        return array_get($this->object->getValue(), 'formatted');
    }

    /**
     * Return the marker position.
     *
     * @return string
     */
    public function position()
    {
        return $this->latitude() . ',' . $this->longitude();
    }

    /**
     * Return the marker latitude.
     *
     * @return double
     */
    public function latitude()
    {
        return array_get($this->object->getValue(), 'marker_latitude');
    }

    /**
     * Return the marker longitude.
     *
     * @return double
     */
    public function longitude()
    {
        return array_get($this->object->getValue(), 'marker_longitude');
    }

    /**
     * Return the formatted position.
     *
     * @return string
     */
    public function formattedPosition()
    {
        return $this->latitude() . ',' . $this->longitude();
    }

    /**
     * Return the formatted latitude.
     *
     * @return double
     */
    public function formattedLatitude()
    {
        return array_get($this->object->getValue(), 'latitude');
    }

    /**
     * Return the longitude.
     *
     * @return double
     */
    public function formattedLongitude()
    {
        return array_get($this->object->getValue(), 'longitude');
    }
}
