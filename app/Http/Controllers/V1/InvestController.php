<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invest\StoreInvestRequest;
use App\Http\Requests\Invest\UpdateInvestRequest;
use App\Models\Invest;

class InvestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Invest::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $invest = Invest::findOrFail($id);

        return response()->json($invest, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvestRequest $request, Invest $invest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invest $invest)
    {
        //
    }
}
