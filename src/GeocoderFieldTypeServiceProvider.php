<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\GeocoderFieldType\Command\ExtendQueryBuilder;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\View\ViewIncludes;
use Illuminate\Contracts\Config\Repository;

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
     * @param GeocoderFieldType $fieldType
     */
    public function boot(ViewIncludes $includes, Repository $config)
    {
        if ($config->get('anomaly.field_type.geocoder::google.key')) {
            $includes->add('cp_scripts', 'anomaly.field_type.geocoder::script');
        }
    }
}
