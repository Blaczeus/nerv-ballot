<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class SettingSeeder extends Seeder
{
    /**
     * Seed core system settings.
     */
    public function run(): void
    {
        Setting::query()->updateOrCreate(
            ['key' => 'vote_price'],
            ['value' => '100', 'type' => 'float'],
        );

        Setting::query()->updateOrCreate(
            ['key' => 'voting_enabled'],
            ['value' => 'true', 'type' => 'boolean'],
        );

        Cache::forget('setting_vote_price');
        Cache::forget('setting_voting_enabled');
    }
}
