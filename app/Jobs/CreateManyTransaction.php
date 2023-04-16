<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateManyTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaction, $params;

    /**
     * Create a new job instance.
     */
    public function __construct($transaction, $params)
    {
        $this->transaction = $transaction;
        $this->params = $params;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        for ($x = 0; $x < $this->params["tran_count"]; $x++) {
            Transaction::create([
                "user_id" => $this->params["user_id"],
                "amount" => $this->params["amount"],
                "pay_date" => $this->params["pay_date"],
            ]);
        }
    }
}