<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeQuery;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class GeocoderFieldTypeQuery
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\GeocoderFieldType
 */
class GeocoderFieldTypeQuery extends FieldTypeQuery
{

    /*public function distance(Builder $query, $distance)
    {
        $query->selectRaw(
            '(
    3959 * acos (
      cos ( radians(41.4998592) )
      * cos( radians( location_latitude ) )
      * cos( radians( location_longitude ) - radians(-90.299594) )
      + sin ( radians(41.4998592) )
      * sin( radians( location_latitude ) )
    )
  ) AS distance'
        );
    }*/
}
