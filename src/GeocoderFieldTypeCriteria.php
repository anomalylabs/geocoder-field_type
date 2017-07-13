<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\GeocoderFieldType\Command\GetPoint;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCriteria;
use Grimzy\LaravelMysqlSpatial\Types\Point;

/**
 * Class GeocoderFieldTypeCriteria
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GeocoderFieldTypeCriteria extends FieldTypeCriteria
{

    /**
     * Select distance to a point
     * from the provided point.
     *
     * @param      $point
     * @param bool $formatted
     */
    public function selectDistance($point, $formatted = false)
    {
        $column = $this->fieldType->getFieldName();

        if (!$point instanceof Point) {
            $point = $this->dispatch(new GetPoint($point));
        }

        if ($formatted) {
            $column .= '_formatted';
        }

        $this->query->selectDefault()->addSelect(
            $this->query->getConnection()->raw(
                "ST_Distance(`{$column}_point`, GeomFromText('{$point->toWkt()}')) AS {$column}_distance"
            )
        );
    }
}
