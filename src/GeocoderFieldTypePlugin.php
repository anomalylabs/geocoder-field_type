<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\GeocoderFieldType\Command\GetPoint;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Illuminate\Foundation\Bus\DispatchesJobs;

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
            new \Twig_SimpleFunction(
                'geocode',
                function ($address) {
                    return $this->dispatch(new GetPoint($address));
                }
            ),
        ];
    }
}
