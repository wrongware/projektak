<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['start', 'end', 'billable', 'worker_id'];

    /**
     * The fields that are supposed to be cast to timestamp.
     *
     * @var array
     */
    public $dates = ['start', 'end', 'created_at', 'updated_at'];

    /**
     * Specifies the belongs to relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Specifies the belongs to relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * Returns the runnning task log.
     *
     * @return \App\TaskLog|int
     */
    public static function running()
    {
        $taskLog = auth()->user()->worker->taskLogs
            ->where('end', null)
            ->first();

        if (! $taskLog) {
            return 0;
        }

        return $taskLog
            ->load(['task', 'task.project', 'task.project.client', 'task.status']);
    }
}
