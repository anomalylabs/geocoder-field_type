<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeSchema;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class GeocoderFieldTypeSchema
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\GeocoderFieldType
 */
class GeocoderFieldTypeSchema extends FieldTypeSchema
{

    /**
     * Columns suffixes to manage.
     *
     * @var array
     */
    protected $suffixes = [
        '_address',
        '_formatted',
        '_latitude',
        '_longitude',
        '_formatted_latitude',
        '_formatted_longitude'
    ];

    /**
     * Add the field type columns.
     *
     * @param Blueprint           $table
     * @param AssignmentInterface $assignment
     */
    public function addColumn(Blueprint $table, AssignmentInterface $assignment)
    {
        $this->schema->table(
            $table,
            function (Blueprint $table) use ($assignment) {

                $table->string($this->fieldType->getField() . '_address')->nullable(true);
                $table->string($this->fieldType->getField() . '_formatted')->nullable(true);
                $table->decimal($this->fieldType->getField() . '_latitude', 10, 7)->nullable(true);
                $table->decimal($this->fieldType->getField() . '_longitude', 10, 7)->nullable(true);
                $table->decimal($this->fieldType->getField() . '_formatted_latitude', 10, 7)->nullable(true);
                $table->decimal($this->fieldType->getField() . '_formatted_longitude', 10, 7)->nullable(true);
            }
        );
    }

    /**
     * Rename the field type columns.
     *
     * @param Blueprint $table
     * @param FieldType $from
     */
    public function renameColumn(Blueprint $table, FieldType $from)
    {
        foreach ($this->suffixes as $suffix) {
            $table->renameColumn($from->getColumnName() . $suffix, $this->fieldType->getColumnName() . $suffix);
        }
    }

    /**
     * Drop the field type columns.
     *
     * @param Blueprint $table
     */
    public function dropColumn(Blueprint $table)
    {
        $this->schema->table(
            $table,
            function (Blueprint $table) {

                foreach ($this->suffixes as $suffix) {
                    $table->dropColumn($this->fieldType->getColumnName() . $suffix);
                }
            }
        );
    }
}
