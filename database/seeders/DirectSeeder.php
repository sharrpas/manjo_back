<?php

namespace Database\Seeders;

use App\Models\DirectSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DirectSetting::query()->count() == 0) {
            DirectSetting::query()->create([
                'name' => 'mac',
                'value' => json_encode('d4d4da555118'),
            ]);
        }
    }
}
