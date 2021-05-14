<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\ETIM\EtimUpdate;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadEtimIXF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    public $date;

        /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $date)
    {
        $this->user = $user;
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EtimUpdate $update)
    {
        Log::channel('activity')->info("DownloadEtimIXF started by user: " . $this->user->name);
        $update->download($this->date);
        $update->unpack($update->path, $update->zipfilename);
        Log::channel('activity')->info('DownloadEtimIXF started by user: ' . $this->user->name . ' - has finished');
         //
    }
}
