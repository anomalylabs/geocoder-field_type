<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class GeocoderFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\GeocoderFieldType
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
        'zoom'   => 13
    ];

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
