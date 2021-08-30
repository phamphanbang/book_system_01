<?php

namespace App\Jobs;

use App\Exports\CartAllExport;
use App\Exports\RevenueExport;
use App\Mail\MonthlyReportMail;
use App\Mail\ReceiveReview;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Facades\Excel;

class MonthlyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('any_key')->allow(2)->every(10)->then(function () {
            Mail::to(env('MAIL_TO'))->queue(new MonthlyReportMail);              
        }, function () {
            return $this->release(2);
        });
    }

    public $tries = 5;

    public $timeout = 120;
}
