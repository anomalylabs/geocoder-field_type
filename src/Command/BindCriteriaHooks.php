<?php namespace Anomaly\GeocoderFieldType\Command;

use Anomaly\Streams\Platform\Entry\EntryCriteria;

/**
 * Class BindCriteriaHooks
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BindCriteriaHooks
{

    /**
     * Handle the command.
     */
    public function handle()
    {

        EntryCriteria::_bind(
            'select_distance',
            function ($field, $point) {

                /* @var EntryCriteria $this */
                $this
                    ->getFieldTypeCriteria($field)
                    ->selectDistance($point, array_get(func_get_args(), 2, false));

                return $this;
            }
        );

        EntryCriteria::_bind(
            'where_distance',
            function ($field, $point, $operator, $distance) {

                /* @var EntryCriteria $this */
                $this
                    ->getFieldTypeCriteria($field)
                    ->whereDistance($point, $operator, $distance, array_get(func_get_args(), 4, false));

                return $this;
            }
        );

        EntryCriteria::_bind(
            'or_where_distance',
            function ($field, $point, $operator, $distance) {

                /* @var EntryCriteria $this */
                $this
                    ->getFieldTypeCriteria($field)
                    ->orWhereDistance($point, $operator, $distance, array_get(func_get_args(), 4, false));

                return $this;
            }
        );
    }

}
