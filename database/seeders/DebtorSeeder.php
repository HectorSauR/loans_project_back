<?php

namespace Database\Seeders;

use App\Models\Debtor;
use App\Models\Loan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DebtorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Debtor::factory()
        ->count(10) // Por ejemplo, crear 10 inversores
        ->has(Loan::factory()->count(5)) // Cada inversor tendrá 5 registros "invests"
        ->create();
    }
}
