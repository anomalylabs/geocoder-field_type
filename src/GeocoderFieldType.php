<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Illuminate\Contracts\Config\Repository;

/**
 * Class GeocoderFieldType
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GeocoderFieldType extends FieldType
{

    /**
     * No database column.
     *
     * @var bool
     */
    protected $columnType = false;

    /**
     * The input view.
     *
     * @var string
     */
    protected $inputView = 'anomaly.field_type.geocoder::input';

    /**
     * The filter view.
     *
     * @var string
     */
    protected $filterView = 'anomaly.field_type.geocoder::filter';

    /**
     * The default config.
     *
     * @var array
     */
    protected $config = [
        'height' => 400,
        'zoom'   => 13,
    ];

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $configuration;

    /**
     * Create a new GeocoderFieldType instance.
     *
     * @param Repository $configuration
     */
    public function __construct(Repository $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Return the Google Maps API Key
     *
     * @return string
     */
    public function key()
    {
        return $this->configuration->get($this->getNamespace('google.key'));
    }

    /**
     * Get the value to validate.
     *
     * @param null $default
     * @return array
     */
    public function getValidationValue($default = null)
    {
        return array_filter(parent::getValidationValue($default));
    }
}
