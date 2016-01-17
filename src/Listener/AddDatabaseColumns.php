<?php namespace Anomaly\GeocoderFieldType\Listener;

use Anomaly\GeocoderFieldType\GeocoderFieldType;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreated;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class AddDatabaseColumns
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\GeocoderFieldType\Listener
 */
class AddDatabaseColumns
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
     * @param AssignmentWasCreated $event
     */
    public function handle(AssignmentWasCreated $event)
    {
        $assignment = $event->getAssignment();

        $fieldType = $assignment->getFieldType();

        if (!$fieldType instanceof GeocoderFieldType) {
            return;
        }

        $table = $assignment->getStreamPrefix() . $assignment->getStreamSlug();

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($assignment) {

                $table->string($assignment->getFieldSlug() . '_address')->nullable(true);
                $table->string($assignment->getFieldSlug() . '_formatted')->nullable(true);
                $table->double($assignment->getFieldSlug() . '_latitude', 10, 7)->nullable(true);
                $table->double($assignment->getFieldSlug() . '_longitude', 10, 7)->nullable(true);
                $table->double($assignment->getFieldSlug() . '_formatted_latitude', 10, 7)->nullable(true);
                $table->double($assignment->getFieldSlug() . '_formatted_longitude', 10, 7)->nullable(true);
            }
        );
    }
}
