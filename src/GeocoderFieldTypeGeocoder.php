<?php namespace Anomaly\GeocoderFieldType;

use Guzzle\Http\Client;
use Illuminate\Contracts\Cache\Repository;

/**
 * Class GeocoderFieldTypeGeocoder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GeocoderFieldTypeGeocoder
{

    /**
     * The field type instance.
     *
     * @var GeocoderFieldType
     */
    protected $fieldType;

    /**
     * @var Repository
     */
    protected $cache;

    /**
     * Create a new GeocoderFieldTypePoint instance.
     *
     * @param GeocoderFieldType $fieldType
     * @param Repository        $cache
     */
    public function __construct(GeocoderFieldType $fieldType, Repository $cache)
    {
        $this->cache     = $cache;
        $this->fieldType = $fieldType;
    }

    /**
     * Convert an address to a point.
     *
     * @param $address
     * @return GeocoderFieldTypePoint|null
     */
    public function convert($address)
    {
        $json = $this->cache->rememberForever(
            __METHOD__ . md5($address),
            function () use ($address) {

                return (new Client())->get(
                    'https://maps.googleapis.com/maps/api/geocode/json',
                    null,
                    [
                        'query' => [
                            'address' => urlencode($address),
                            'key'     => $this->fieldType->key(),
                        ],
                    ]
                )->send()->getBody(true);
            }
        );

        if (!$result = array_get(json_decode($json, true), 'results.0')) {
            return null;
        }

        $result['address'] = $address;

        return new GeocoderFieldTypePoint($result);
    }
}
