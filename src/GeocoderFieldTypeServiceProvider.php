<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\GeocoderFieldType\Command\ExtendQueryBuilder;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\View\ViewIncludes;

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
     * The addon instance.
     *
     * @var GeocoderFieldType
     */
    protected $addon;

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
     */
    public function register()
    {
        if (!$this->addon->isSpatialEnabled()) {
            return;
        }

        $this->dispatch(new ExtendQueryBuilder());
    }

    /**
     * Boot the addon.
     *
     * @param ViewIncludes $includes
     */
    public function boot(ViewIncludes $includes)
    {
        $includes->add('cp_scripts', 'anomaly.field_type.geocoder::script');
    }
}
