<?php namespace Anomaly\GeocoderFieldType;

use GuzzleHttp\Client;
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
     * @param Repository $cache
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
        if (!$address) {
            return null;
        }

        $result = json_decode(
            $this->cache->rememberForever(
                __METHOD__ . md5($address),
                function () use ($address) {

                    return (new Client())->get(
                        'https://maps.googleapis.com/maps/api/geocode/json',
                        [
                            'query' => [
                                'address' => urlencode($address),
                                'key'     => $this->fieldType->key(),
                            ],
                        ]
                    )->getBody()->getContents();
                }
            ),
            true
        );

        if (isset($result['error_message'])) {

            $this->cache->forget(__METHOD__ . md5($address));

            return null;
        }

        if (!$result = array_get($result, 'results.0')) {
            return null;
        }

        $result['address'] = $address;

        return new GeocoderFieldTypePoint($result);
    }

    /**
     * Convert an address to a point.
     *
     * @param $latitude
     * @param $longitude
     * @return GeocoderFieldTypePoint|null
     * @internal param $address
     */
    public function reverse($latitude, $longitude)
    {
        $json = $this->cache->rememberForever(
            __METHOD__ . md5($latitude . $longitude),
            function () use ($latitude, $longitude) {

                return (new Client())->get(
                    'https://maps.googleapis.com/maps/api/geocode/json',
                    [
                        'query' => [
                            'latlng' => $latitude . ',' . $longitude,
                            'key'    => $this->fieldType->key(),
                        ],
                    ]
                )->getBody()->getContents();
            }
        );

        if (!$result = array_get(json_decode($json, true), 'results.0')) {
            return null;
        }

        return new GeocoderFieldTypePoint($result);
    }
}
