<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Investor\StoreInvestorRequest;
use App\Http\Requests\Investor\UpdateInvestorRequest;
use App\Models\Investor;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Investor::all(), 200);
    }

    public function getInvests($id)
    {
        $investor = Investor::findOrFail($id);

        if (!$investor) {
            return response()->json(['error' => 'Inversor no encontrado'], 404);
        }

        $investor['invests'] = $investor->invests;

        return response()->json($investor, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvestorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Investor $investor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvestorRequest $request, Investor $investor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Investor $investor)
    {
        //
    }
}
