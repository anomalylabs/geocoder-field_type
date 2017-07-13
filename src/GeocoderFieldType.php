<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Doctrine\DBAL\Types\Type;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;

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
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new GeocoderFieldType instance.
     *
     * @param Container  $container
     * @param Repository $configuration
     */
    public function __construct(Repository $configuration, Container $container)
    {
        $this->container     = $container;
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
     * Return if spatial utilities
     * are installed and enabled.
     *
     * @return bool
     */
    public function isSpatialEnabled()
    {
        if (isset($this->cache[__METHOD__])) {
            return $this->cache[__METHOD__];
        }

        return $this->cache[__METHOD__] = Type::hasType('point');
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

    /**
     * Get the unique column name.
     *
     * @return string
     */
    public function getUniqueColumnName()
    {
        return $this->field . '_formatted';
    }

    /**
     * Return a new geocoder.
     *
     * @return GeocoderFieldTypeGeocoder
     */
    public function newGeocoder()
    {
        return $this->container->make(
            GeocoderFieldTypeGeocoder::class,
            [
                'fieldType' => $this,
            ]
        );
    }
}
