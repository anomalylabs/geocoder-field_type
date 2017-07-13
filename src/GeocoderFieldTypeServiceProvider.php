<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\GeocoderFieldType\Command\BindCriteriaHooks;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Entry\EntryCriteria;
use Anomaly\Streams\Platform\Entry\EntryQueryBuilder;

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

        EntryCriteria::_bind(
            'select_distance',
            function ($field, $point) {

                $this
                    ->getFieldTypeCriteria($field)
                    ->selectDistance($point, array_get(func_get_args(), 2, false));

                return $this;
            }
        );

        EntryQueryBuilder::_bind(
            'select_distance',
            function ($field, $point) {

                $this
                    ->getFieldTypeCriteria($field)
                    ->selectDistance($point, array_get(func_get_args(), 2, false));

                return $this;
            }
        );
    }
}
