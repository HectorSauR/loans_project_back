<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\StoreLoanRequest;
use App\Http\Requests\Loan\UpdateLoanRequest;
use App\Http\Resources\V1\Loan\LoanCollection;
use App\Models\Loan;
use Exception;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        return response()->json(new LoanCollection($user->loans), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoanRequest $request)
    {
        $data = $request->all();

        try {
            $loan = Loan::createNewLoan($data);
        } catch (Exception $e) {
            return response()->json(
                [
                    "detail" => $e->getMessage()
                ],
                $e->getCode()
            );
        }

        return response()->json($loan, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = auth()->user();
        $loan = $user->loans->where('id', $id)->first();

        if (!$loan) {
            return response()->json(["error" => "Not Found"], 404);
        }

        return response()->json($loan, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoanRequest $request, int $id)
    {
        $user = auth()->user();
        $loan = $user->loans->where('id', $id)->first();

        if (!$loan) {
            return response()->json(["error" => "Not Found"], 404);
        }

        $loan->update($request->all());

        return response()->json($loan, 200);
    }

    public function finishLoan(int $id)
    {
        $user = auth()->user();
        $loan = $user->loans->where('id', $id)->first();

        if (!$loan) {
            return response()->json(["error" => "Not Found"], 404);
        }

        $loan->finish();

        return response()->json([
            "detail" => "Prestamo finalizado con éxito!"
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
