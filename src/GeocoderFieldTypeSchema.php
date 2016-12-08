<?php namespace Anomaly\GeocoderFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeSchema;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class GeocoderFieldTypeSchema
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
        '_formatted_longitude',
    ];

    /**
     * Add the field type columns.
     *
     * @param Blueprint           $table
     * @param AssignmentInterface $assignment
     */
    public function addColumn(Blueprint $table, AssignmentInterface $assignment)
    {
        $nullable = !$assignment->isTranslatable() ? !$assignment->isRequired() : true;

        $table->string($this->fieldType->getField() . '_address')->nullable($nullable);
        $table->string($this->fieldType->getField() . '_formatted')->nullable($nullable);
        $table->decimal($this->fieldType->getField() . '_latitude', 10, 7)->nullable($nullable);
        $table->decimal($this->fieldType->getField() . '_longitude', 10, 7)->nullable($nullable);
        $table->decimal($this->fieldType->getField() . '_formatted_latitude', 10, 7)->nullable($nullable);
        $table->decimal($this->fieldType->getField() . '_formatted_longitude', 10, 7)->nullable($nullable);

        if ($assignment->isUnique() && !$assignment->isTranslatable()) {
            $table->unique(
                $this->fieldType->getColumnName() . '_address',
                md5('unique_' . $this->fieldType->getColumnName())
            );
        }
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
     * Update an existing column.
     *
     * @param Blueprint           $table
     * @param AssignmentInterface $assignment
     */
    public function updateColumn(Blueprint $table, AssignmentInterface $assignment)
    {
        $nullable = !$assignment->isTranslatable() ? !$assignment->isRequired() : true;

        $table->string($this->fieldType->getField() . '_address')->nullable($nullable)->change();
        $table->string($this->fieldType->getField() . '_formatted')->nullable($nullable)->change();
        $table->decimal($this->fieldType->getField() . '_latitude', 10, 7)->nullable($nullable)->change();
        $table->decimal($this->fieldType->getField() . '_longitude', 10, 7)->nullable($nullable)->change();
        $table->decimal($this->fieldType->getField() . '_formatted_latitude', 10, 7)->nullable($nullable)->change();
        $table->decimal($this->fieldType->getField() . '_formatted_longitude', 10, 7)->nullable($nullable)->change();

        /**
         * Mark the column unique if desired and not translatable.
         * Otherwise, drop the unique index.
         */
        $connection = $this->schema->getConnection();
        $manager    = $connection->getDoctrineSchemaManager();
        $doctrine   = $manager->listTableDetails($connection->getTablePrefix() . $table->getTable());

        // The unique index name.
        $unique = md5('unique_' . $this->fieldType->getColumnName());

        /**
         * If the assignment is unique and not translatable
         * and the table does not already have the given the
         * given table index then go ahead and add it.
         */
        if ($assignment->isUnique() && !$assignment->isTranslatable() && !$doctrine->hasIndex($unique)) {
            $table->unique($this->fieldType->getColumnName() . '_address', $unique);
        }

        /**
         * If the assignment is NOT unique and not translatable
         * and the table DOES have the given table index
         * then we need to remove.
         */
        if (!$assignment->isUnique() && !$assignment->isTranslatable() && $doctrine->hasIndex($unique)) {
            $table->dropIndex(md5('unique_' . $this->fieldType->getColumnName()));
        }
    }

    /**
     * Drop the field type columns.
     *
     * @param Blueprint $table
     */
    public function dropColumn(Blueprint $table)
    {
        foreach ($this->suffixes as $suffix) {
            $table->dropColumn($this->fieldType->getColumnName() . $suffix);
        }
    }
}
