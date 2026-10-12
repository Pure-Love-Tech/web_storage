<?php

namespace App\Console\Commands\Transactions;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteUnpaid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:delete-unpaid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to delete the unpaid transactions after 1 day';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $transactions = Transaction::where('created_at', '<', Carbon::now()->subDay())->unpaid()->get();
        if ($transactions->count() > 0) {
            foreach ($transactions as $transaction) {
                $transaction->delete();
            }
        }
    }
}
