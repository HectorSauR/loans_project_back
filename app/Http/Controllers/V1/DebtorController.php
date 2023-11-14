<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Debtor\StoreDebtorRequest;
use App\Http\Requests\Debtor\UpdateDebtorRequest;
use App\Http\Requests\Loan\StoreLoanRequest;
use App\Models\Debtor;
use App\Models\Investor;
use App\Models\Loan;
use Illuminate\Http\Request;

class DebtorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json(Debtor::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDebtorRequest $request)
    {
        $user = $request->user();

        $data = $request->all();
        $data["user_id"] = $user->id;

        $loanData = $data["loan"];
        unset($data["loan"]);

        $debtor = Debtor::create($data);

        $loanData["debtor_id"] = $debtor->id;
        $loan = Loan::createNewLoan($loanData, $user);

        $debtor->loan = $loan;

        return response()->json($debtor, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $investor = Debtor::findOrFail($id);

        return response()->json($investor, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDebtorRequest $request, int $id)
    {
        $data = $request->all();
        $debtor = Debtor::findOrFail($id);

        $debtor->update($data);

        return response()->json($debtor, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debtor $debtor)
    {
        //
    }

    public function addLoan(StoreLoanRequest $request, int $id)
    {
        $data = $request->all();

        $data["debtor_id"] = $id;
        $loan = Loan::createNewLoan($data, $request->user());

        return response()->json($loan, 200);
    }
}
