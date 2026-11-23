<?php

namespace App\\Console\\Commands;

use Illuminate\\Console\\Command;
use Illuminate\\Support\\Facades\\DB;
use Illuminate\\Support\\Facades\\Log;

class UpdatePayoutAmount extends Command
{
    protected $signature = 'payout:update-amount {mode : discount|reset|sync}';

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

            if ($mode === 'sync') {
                // Existing weekend discount runs from Friday 00:01 until Monday 00:00 WIB.
                $isWeekendDiscountPeriod = $now->dayOfWeekIso >= 5;

                // The additional Rp500 discount applies only during December 2026, 11:00-19:59 WIB.
                $isDecemberDiscountPeriod = $now->year === 2026
                    && $now->month === 12
                    && $now->day >= 1
                    && $now->day <= 31
                    && $now->hour >= 11
                    && $now->hour < 20;

                $totalDiscount = $isWeekendDiscountPeriod ? $discount : 0;

                if ($isDecemberDiscountPeriod) {
                    $decemberDiscountSql = 'CASE WHEN amount_default > 500 THEN 500 ELSE 0 END';
                } else {
                    $decemberDiscountSql = '0';
                }

                $affectedRows = DB::table('payout_rates')->update([
                    'amount' => DB::raw(
                        'GREATEST(amount_default - ' . $totalDiscount . ' - ' . $decemberDiscountSql . ', 0)'
                    ),
                ]);

                Log::info('PAYOUT_SCHEDULE_SUCCESS', [
                    'mode' => 'sync',
                    'datetime' => $now->format('Y-m-d H:i:s'),
                    'affected_rows' => $affectedRows,
                    'weekend_discount_applied' => $isWeekendDiscountPeriod,
                    'december_discount_applied' => $isDecemberDiscountPeriod,
                    'weekend_discount' => $totalDiscount,
                    'december_discount' => $isDecemberDiscountPeriod ? 500 : 0,
                ]);

                $this->info("Payout amounts synchronized. Rows: {$affectedRows}");

                return self::SUCCESS;
            }

            Log::warning('PAYOUT_SCHEDULE_INVALID_MODE', [
                'mode' => $mode,
                'datetime' => $now->format('Y-m-d H:i:s'),
            ]);

            $this->error('Invalid mode. Use discount, reset, or sync.');

            return self::FAILURE;
        } catch (\\Throwable $e) {
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
