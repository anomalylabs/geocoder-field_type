<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

/**
 * Class GeocoderFieldTypeServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\GeocoderFieldType
 */
class GeocoderFieldTypeServiceProvider extends AddonServiceProvider
{

    /**
     * The addon listeners.
     *
     * @var array
     */
    protected $listeners = [
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreated' => [
            'Anomaly\GeocoderFieldType\Listener\AddDatabaseColumns'
        ],
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeleted' => [
            'Anomaly\GeocoderFieldType\Listener\DropDatabaseColumns'
        ]
    ];

    /**
     * The singleton bindings.
     *
     * @var array
     */
    protected $singletons = [
        'Anomaly\GeocoderFieldType\GeocoderFieldTypeModifier' => 'Anomaly\GeocoderFieldType\GeocoderFieldTypeModifier'
    ];
}
