<?php

namespace App\Jobs;


use App\Models\User;
use App\Models\Etim\EtimProductClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateEtimProductClasses implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $user;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;
    public $date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $date)
    {
        
        $this->user = $user;
        $this->date = $date;
        // dd($this->date);
  
    }

    /**
    * Determine the time at which the job should timeout.
    *
    * @return \DateTime
    */
    public function retryUntil()
    {
        return now()->addSeconds(7200);
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
       Log::channel('activity')->info('UpdateEtimProductClasses started by user: '. $this->user->name);
       $product_classes = new EtimProductClass;
       $product_classes->updateDefinitions($this->date);
       Log::channel('activity')->info('UpdateEtimProductClasses started by user: ' . $this->user->name . ' - has finished');

    }
}
