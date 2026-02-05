<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillVettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    \App\Models\BillVetting::create([
        'pa_code' => '051/PHIS/2601/118279/ZeeWay/2',
        'full_name' => 'John Doe Test',
        'policy_no' => 'POL-12345',
        'package_limit' => 50000.00,
        'pry_hcp' => 'General Hospital'
    ]);
}
}
