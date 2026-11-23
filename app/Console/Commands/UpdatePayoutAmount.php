<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePayoutAmount extends Command
{
    protected $signature = 'payout:update-amount {mode : discount|reset|daytime-discount|daytime-reset}';

    protected $description = 'Update payout amount';

    public function handle()
    {
        $mode = $this->argument('mode');

        $discount = (int) config('services.payout.weekend_discount', 2000);
        $daytimeDiscount = 500;
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

            if ($mode === 'daytime-discount' || $mode === 'daytime-reset') {
                // Mirror the existing weekly discount (Friday through Sunday)
                // and apply an additional Rp500 only during the daytime window.
                $isWeekendDiscountActive = $now->isFriday()
                    || $now->isSaturday()
                    || $now->isSunday();

                $activeWeekendDiscount = $isWeekendDiscountActive ? $discount : 0;
                $activeDaytimeDiscount = $mode === 'daytime-discount'
                    ? $daytimeDiscount
                    : 0;
                $totalDiscount = $activeWeekendDiscount + $activeDaytimeDiscount;

                $affectedRows = DB::table('payout_rates')->update([
                    'amount' => DB::raw(
                        'GREATEST(amount_default - ' . $totalDiscount . ', 0)'
                    ),
                ]);

                Log::info('PAYOUT_SCHEDULE_SUCCESS', [
                    'mode' => $mode,
                    'datetime' => $now->format('Y-m-d H:i:s'),
                    'affected_rows' => $affectedRows,
                    'weekend_discount' => $activeWeekendDiscount,
                    'daytime_discount' => $activeDaytimeDiscount,
                    'total_discount' => $totalDiscount,
                ]);

                $this->info(
                    "Payout {$mode} applied. Rows: {$affectedRows}; total discount: {$totalDiscount}"
                );

                return self::SUCCESS;
            }

            Log::warning('PAYOUT_SCHEDULE_INVALID_MODE', [
                'mode' => $mode,
                'datetime' => $now->format('Y-m-d H:i:s'),
            ]);

            $this->error('Invalid mode. Use discount, reset, daytime-discount, or daytime-reset.');

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
