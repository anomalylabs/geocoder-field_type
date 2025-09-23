<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\GeocoderFieldType\Command\Geocode;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Twig\TwigFunction;

/**
 * Class GeocoderFieldTypePlugin
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GeocoderFieldTypePlugin extends Plugin
{

    use DispatchesJobs;

    /**
     * Get the functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'geocode',
                function ($parameters) {
                    return dispatch_sync(new Geocode($parameters));
                }
            ),
        ];
    }
}
