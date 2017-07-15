<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\GeocoderFieldType\Command\GetPoint;
use Anomaly\GeocoderFieldType\Spatial\Point;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCriteria;
use Anomaly\Streams\Platform\Support\Length;

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
    public function selectDistance($point, $formatted = false, $as = null)
    {
        $point  = $this->getPoint($point);
        $column = $this->getColumn($formatted, false);

        $as = $as ?: $column . '_distance';

        $this->query->selectDefault()->addSelect(
            $this->query->getConnection()->raw(
                "ST_Distance(`{$column}_point`, GeomFromText('{$point->text()}')) AS {$as}"
            )
        );
    }

    /**
     * Add where to restrict by
     * distance from provided point.
     *
     * @param      $point
     * @param      $operator
     * @param      $distance
     * @param bool $formatted
     * @throws \Exception
     */
    public function whereDistance($point, $operator, $distance, $formatted = false)
    {
        $point  = $this->getPoint($point);
        $column = $this->getColumn($formatted);

        if (!is_numeric($distance)) {
            $distance = (new Length($distance))->degrees();
        }

        $this->query->whereRaw(
            "ST_Distance(`{$column}`, GeomFromText('{$point->text()}')) {$operator} {$distance}"
        );
    }

    /**
     * Add orWhere to restrict by
     * distance from provided point.
     *
     * @param      $point
     * @param      $operator
     * @param      $distance
     * @param bool $formatted
     * @throws \Exception
     */
    public function orWhereDistance($point, $operator, $distance, $formatted = false)
    {
        $point  = $this->getPoint($point);
        $column = $this->getColumn($formatted);

        if (!is_numeric($distance)) {
            $distance = (new Length($distance))->degrees();
        }

        $this->query->orWhereRaw(
            "ST_Distance(`{$column}`, GeomFromText('{$point->text()}')) {$operator} {$distance}"
        );
    }

    /**
     * Get the column.
     *
     * @param $formatted
     * @return string
     */
    protected function getColumn($formatted, $point = true)
    {
        $column = $this->fieldType->getColumnName();

        if ($point) {
            $column .= '_point';
        }

        if ($formatted) {
            $column .= '_formatted';
        }

        return $column;
    }

    /**
     * Get the point.
     *
     * @param $point
     * @return Point
     */
    protected function getPoint($point)
    {
        if (!$point instanceof Point) {
            $point = $this->dispatch(new GetPoint($point));
        }

        return $point;
    }
}
