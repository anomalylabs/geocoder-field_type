<?php namespace Anomaly\GeocoderFieldType\Command;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class SelectDistance
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SelectDistance
{

    use DispatchesJobs;

    /**
     * The column to
     * use for distance.
     *
     * @var string
     */
    protected $column;

    /**
     * The geometry point.
     *
     * @var mixed
     */
    protected $point;

    /**
     * The query builder.
     *
     * @var Builder
     */
    protected $query;

    /**
     * The formatted point flag.
     *
     * @var bool
     */
    protected $formatted;

    /**
     * Create a new SelectDistance instance.
     *
     * @param string  $column
     * @param mixed   $point
     * @param Builder $query
     * @param bool    $formatted
     */
    public function __construct($column, $point, Builder $query, $formatted = false)
    {
        $this->query     = $query;
        $this->point     = $point;
        $this->column    = $column;
        $this->formatted = $formatted;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {

        if (!$this->point instanceof Point) {
            $this->point = $this->dispatch(new GetPoint($this->point));
        }

        if ($this->formatted) {
            $this->column .= '_formatted';
        }

        $this->query->selectDefault()->addSelect(
            $this->query->getConnection()->raw(
                "st_distance(`{$this->column}_point`, GeomFromText('{$this->point->toWkt()}')) as {$this->column}_distance"
            )
        );
    }
}
