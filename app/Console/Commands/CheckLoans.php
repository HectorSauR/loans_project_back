<?php

namespace App\Console\Commands;

use App\Models\Loan;
use Illuminate\Console\Command;

class CheckLoans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:loans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to load the loan when the date was reached.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $loans = Loan::whereNull('ended_date')->get();

        foreach ($loans as $loan) {
            $lastCharge = $loan->last_charge_date ?? $loan->created_at;
            $interval = ($loan->deadline == 'month') ? now()->diffInMonths($lastCharge) : now()->diffInWeeks($lastCharge);

            if ($interval > 0) {
                // Aplicar lógica para calcular y aplicar intereses
                $interest = $loan->remaining * $loan->interest / 100;
                $loan->remaining += $interest;
                $loan->interest_generated += $interest;
                $loan->last_charge_date = now();
                $loan->save();

                $this->info('Se aplicaron intereses al préstamo ID ' . $loan->id);
            }
        }

        $this->info('Verificación de préstamos completada.');
    }
}
