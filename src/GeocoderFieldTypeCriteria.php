<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\GeocoderFieldType\Command\GetPoint;
use Anomaly\GeocoderFieldType\Spatial\Point;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCriteria;
use Anomaly\Streams\Platform\Support\Length;
use InvalidArgumentException;

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
     * The supported distance operators.
     *
     * @var array
     */
    protected $operators = ['<', '<=', '>', '>=', '=', '!=', '<>'];

    /**
     * Select distance to a point
     * from the provided point.
     *
     * @param      $point
     * @param bool $formatted
     * @param null $as
     * @throws InvalidArgumentException
     */
    public function selectDistance($point, $formatted = false, $as = null)
    {
        $point  = $this->getPoint($point);
        $column = $this->getColumn($formatted, false);

        $as = $this->getAlias($as ?: $column . '_distance');

        $this->query->selectDefault()->selectRaw(
            "ST_Distance(`{$column}_point`, GeomFromText(?)) AS `{$as}`",
            [$point->text()]
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
        $point    = $this->getPoint($point);
        $column   = $this->getColumn($formatted);
        $operator = $this->getOperator($operator);

        if (!is_numeric($distance)) {
            $distance = (new Length($distance))->degrees();
        }

        $this->query->whereRaw(
            "ST_Distance(`{$column}`, GeomFromText(?)) {$operator} ?",
            [$point->text(), $distance]
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
        $point    = $this->getPoint($point);
        $column   = $this->getColumn($formatted);
        $operator = $this->getOperator($operator);

        if (!is_numeric($distance)) {
            $distance = (new Length($distance))->degrees();
        }

        $this->query->orWhereRaw(
            "ST_Distance(`{$column}`, GeomFromText(?)) {$operator} ?",
            [$point->text(), $distance]
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
     * Get the operator.
     *
     * @param $operator
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getOperator($operator)
    {
        $operator = trim((string)$operator);

        if (!in_array($operator, $this->operators, true)) {
            throw new InvalidArgumentException("Invalid distance operator [{$operator}].");
        }

        return $operator;
    }

    /**
     * Get the alias.
     *
     * @param $as
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getAlias($as)
    {
        if (!preg_match('/^[A-Za-z0-9_]+\z/', (string)$as)) {
            throw new InvalidArgumentException("Invalid distance alias [{$as}].");
        }

        return $as;
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
            $point = dispatch_sync(new GetPoint($point));
        }

        return $point;
    }
}
