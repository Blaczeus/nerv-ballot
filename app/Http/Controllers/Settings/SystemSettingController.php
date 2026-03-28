<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SystemSettingController extends Controller
{
    /**
     * Update a system setting value.
     */
    public function update(Request $request, Setting $setting): RedirectResponse
    {
        $allowedKeys = ['vote_price', 'voting_enabled'];

        abort_if(! in_array($setting->key, $allowedKeys, true), 400);

        $value = match ($setting->key) {
            'vote_price' => $request->validate([
                'value' => ['required', 'numeric', 'gt:0'],
            ])['value'],
            'voting_enabled' => $request->validate([
                'value' => ['required', 'boolean'],
            ])['value'],
            default => $request->validate([
                'value' => ['required', 'string'],
            ])['value'],
        };

        $setting->update([
            'value' => (string) $value,
            'type' => match ($setting->key) {
                'vote_price' => 'float',
                'voting_enabled' => 'boolean',
                default => $setting->type,
            },
        ]);

        Cache::forget("setting_{$setting->key}");

        return back()->with('success', 'Setting updated successfully.');
    }
}
