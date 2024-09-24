<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class RatingApprovalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // get all ratings where approved = false and update it to true if created_at < now - 1 hour
        /* $ratings = DB::table('reviews')->where('approved', false)->whereDate('created_at', '<', now()->subHour())->update([
            'approved' => true,
        ]); */
        $ratings = DB::table('reviews')->where('approved', false)/* ->whereDate('created_at', '<', now()->subMinute()) */->update([
            'approved' => true,
        ]);
        logger('itt');
    }
}
