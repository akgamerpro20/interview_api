<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Console\Command;

class TransactionApproveSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trans:approve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $transactions = Transaction::where("status", 0)->where("schedule_date", Carbon::now()->format('Y-m-d H:i'))->get();

        foreach ($transactions as $transaction) {
            $transaction->status = 1;
            $transaction->update();
        }

        \Log::info("Cron Job - " . $transactions);
    }
}