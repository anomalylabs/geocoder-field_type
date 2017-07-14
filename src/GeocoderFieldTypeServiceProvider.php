<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\GeocoderFieldType\Command\ExtendBuilder;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

/**
 * Class GeocoderFieldTypeServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GeocoderFieldTypeServiceProvider extends AddonServiceProvider
{

    /**
     * The addon plugins.
     *
     * @var array
     */
    protected $plugins = [
        GeocoderFieldTypePlugin::class,
    ];

    /**
     * Register the addon.
     *
     * @param GeocoderFieldType $fieldType
     */
    public function register(GeocoderFieldType $fieldType)
    {
        if (!$fieldType->isSpatialEnabled()) {
            return;
        }

        $this->dispatch(new ExtendBuilder());
    }
}
