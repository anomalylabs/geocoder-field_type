<?php namespace Anomaly\GeocoderFieldType\Command;

use Anomaly\Streams\Platform\Entry\EntryQueryBuilder;

/**
 * Class ExtendBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExtendBuilder
{

    /**
     * Handle the command.
     */
    public function handle()
    {

        EntryQueryBuilder::_bind(
            'select_distance',
            function ($field, $point) {

                /* @var EntryQueryBuilder $this */
                $this
                    ->getFieldTypeCriteria($field)
                    ->selectDistance($point, array_get(func_get_args(), 2, false), array_get(func_get_args(), 3, null));

                return $this;
            }
        );

        EntryQueryBuilder::_bind(
            'where_distance',
            function ($field, $point, $operator, $distance) {

                /* @var EntryQueryBuilder $this */
                $this
                    ->getFieldTypeCriteria($field)
                    ->whereDistance($point, $operator, $distance, array_get(func_get_args(), 4, false));

                return $this;
            }
        );

        EntryQueryBuilder::_bind(
            'or_where_distance',
            function ($field, $point, $operator, $distance) {

                /* @var EntryQueryBuilder $this */
                $this
                    ->getFieldTypeCriteria($field)
                    ->orWhereDistance($point, $operator, $distance, array_get(func_get_args(), 4, false));

                return $this;
            }
        );
    }

}
