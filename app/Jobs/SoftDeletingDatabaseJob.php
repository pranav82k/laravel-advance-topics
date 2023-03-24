<?php

namespace App\Jobs;

use Illuminate\Queue\Jobs\DatabaseJob as BaseDatabaseJob;

class SoftDeletingDatabaseJob extends BaseDatabaseJob
{
    /**
     * Delete the job from the queue.
     *
     * @return void
     */
    public function delete()
    {
        // Perform a soft delete of the job record
        $this->job->delete();
    }
}
