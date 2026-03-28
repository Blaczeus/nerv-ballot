<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

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
    }
}
