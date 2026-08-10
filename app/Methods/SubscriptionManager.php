<?php

namespace App\Methods;

use App\Models\FileEntry;
use App\Models\Plan;

class SubscriptionManager
{
    public function getSubscription()
    {
        if ($this->user()) {
            if (licenseType(2) && $this->user()->isSubscribed()) {
                $plan = $this->getPlan('premium');
            } else {
                $plan = $this->getPlan('users');
            }
        } else {
            $plan = $this->getPlan('visitors');
        }
        return $this->structure($plan);
    }

    public function getPlan($alias)
    {
        $plan = Plan::where('alias', $alias)->first();
        return $plan;
    }

    public function structure($plan)
    {
        $userId = $this->user() ? $this->user()->id : null;
        $usedSpace = $this->getClientUsedSpace($userId);
        $structure = [
            "is_premium" => $plan->isPremium(),
            "is_expired" => $this->user() && $this->user()->isSubscribed() ? $this->user()->subscription->isExpired() : null,
            "plan" => $plan,
            "formats" => [
                "storage_space" => $plan->storageSpaceFormatted(),
                "max_file_size" => $plan->maxFileSizeFormatted(),
                "file_expiry_days" => $plan->fileExpiryDaysFormatted(),
            ],
            "storage" => [
                "used" => [
                    "number" => $usedSpace,
                    "formatted" => formatBytes($usedSpace),
                ],
                "remaining" => [
                    "number" => $plan->getStorageSpace() ? $plan->getStorageSpace() - $usedSpace : null,
                    "formatted" => $plan->getStorageSpace() ? formatBytes($plan->getStorageSpace() - $usedSpace) : null,
                ],
                "fullness" => $plan->getStorageSpace() ? $this->calculateStorageFullness($usedSpace, $plan->getStorageSpace()) : 0,
            ],
            "upload" => [
                "max_file_size" => $plan->getMaxFileSize(),
            ],
        ];

        return $structure;
    }

    private function getClientUsedSpace(?int $userId = null): int
    {
        if ($userId) {
            return FileEntry::forUser($userId)->sum('size');
        } else {
            return FileEntry::where([['ip', request()->ip()], ['user_id', null]])->sum('size');
        }
    }

    private function calculateStorageFullness(int $usedSpace, int $totalSpace): float
    {
        if ($totalSpace > 0) {
            return round(($usedSpace * 100) / $totalSpace, 1);
        } else {
            return 0;
        }
    }

    public function user()
    {
        return auth()->user();
    }
}
