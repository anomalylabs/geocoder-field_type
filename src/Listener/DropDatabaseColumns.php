<?php namespace Anomaly\GeocoderFieldType\Listener;

use Anomaly\GeocoderFieldType\GeocoderFieldType;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeleted;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class DropDatabaseColumns
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\GeocoderFieldType\Listener
 */
class DropDatabaseColumns
{

    /**
     * The schema builder.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * Create a new StreamSchema instance.
     */
    public function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Handle the event.
     *
     * @param AssignmentWasDeleted $event
     */
    public function handle(AssignmentWasDeleted $event)
    {
        $assignment = $event->getAssignment();

        $fieldType = $assignment->getFieldType();

        if (!$fieldType instanceof GeocoderFieldType) {
            return;
        }

        $table = $assignment->getStreamPrefix() . $assignment->getStreamSlug();

        if (!$this->schema->hasTable($table)) {
            return;
        }

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($assignment) {

                $table->dropColumn($assignment->getFieldSlug() . '_address');
                $table->dropColumn($assignment->getFieldSlug() . '_formatted');
                $table->dropColumn($assignment->getFieldSlug() . '_latitude');
                $table->dropColumn($assignment->getFieldSlug() . '_longitude');
                $table->dropColumn($assignment->getFieldSlug() . '_formatted_latitude');
                $table->dropColumn($assignment->getFieldSlug() . '_formatted_longitude');
            }
        );
    }
}
