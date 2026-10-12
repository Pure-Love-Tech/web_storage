<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePayoutAmount extends Command
{
    protected $signature = 'payout:update-amount {mode : discount|reset}';

    protected $description = 'Update payout amount';

    public function handle()
    {
        $mode = $this->argument('mode');

        $discount = (int) config('services.payout.weekend_discount', 2000);

        $now = now('Asia/Jakarta');

        Log::info('PAYOUT_SCHEDULE_STARTED', [
            'mode' => $mode,
            'datetime' => $now->format('Y-m-d H:i:s'),
            'day' => $now->format('l'),
            'discount' => $discount,
        ]);

        try {
            if ($mode === 'discount') {
                $affectedRows = DB::table('payout_rates')->update([
                    'amount' => DB::raw(
                        'GREATEST(amount_default - ' . $discount . ', 0)'
                    ),
                ]);

                Log::info('PAYOUT_SCHEDULE_SUCCESS', [
                    'mode' => 'discount',
                    'datetime' => $now->format('Y-m-d H:i:s'),
                    'affected_rows' => $affectedRows,
                    'discount' => $discount,
                ]);

                $this->info("Payout discount applied. Rows: {$affectedRows}");

                return self::SUCCESS;
            }

            if ($mode === 'reset') {
                $affectedRows = DB::table('payout_rates')->update([
                    'amount' => DB::raw('amount_default'),
                ]);

                Log::info('PAYOUT_SCHEDULE_SUCCESS', [
                    'mode' => 'reset',
                    'datetime' => $now->format('Y-m-d H:i:s'),
                    'affected_rows' => $affectedRows,
                ]);

                $this->info("Payout amount reset. Rows: {$affectedRows}");

                return self::SUCCESS;
            }

            Log::warning('PAYOUT_SCHEDULE_INVALID_MODE', [
                'mode' => $mode,
                'datetime' => $now->format('Y-m-d H:i:s'),
            ]);

            $this->error('Invalid mode. Use discount or reset.');

            return self::FAILURE;

        } catch (\Throwable $e) {
            Log::error('PAYOUT_SCHEDULE_FAILED', [
                'mode' => $mode,
                'datetime' => $now->format('Y-m-d H:i:s'),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
