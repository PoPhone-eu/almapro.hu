<?php

namespace App\Console\Commands;

use App\Jobs\RatingApprovalJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class updateRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // run RatingApprovalJob job:
        $now = now();
        $time = $now->subHour();
        // we need to approve all reviews that are not approved and were created minimum 1 hour ago or older:
        $reviews = DB::table('reviews')->where('approved', false)->get();
        foreach ($reviews as $review) {
            if ($review->created_at < $time) {
                DB::table('reviews')->where('id', $review->id)->update([
                    'approved' => true,
                ]);
            }
        }
    }
}
