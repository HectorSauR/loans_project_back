<?php

namespace Database\Seeders;

use App\Models\Invest;
use App\Models\Investor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Investor::factory()
        ->count(10) // Por ejemplo, crear 10 inversores
        ->has(Invest::factory()->count(5)) // Cada inversor tendrá 5 registros "invests"
        ->create();
    }
}
