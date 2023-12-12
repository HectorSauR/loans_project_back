<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invest\StoreInvestRequest;
use App\Http\Requests\Invest\UpdateInvestRequest;
use App\Http\Resources\V1\Invest\InvestCollection;
use App\Http\Resources\V1\Invest\InvestResource;
use App\Models\Invest;

class InvestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return response()->json(new InvestCollection($user->invests), 200);
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
        $invest = Invest::where('id', $id)->whereHas('investor.user', function ($query) {
            $query->where('id', auth()->user()->id);
        })->get();

        if (count($invest) == 0) {
            response()->json(['error' => 'Not found'], 404);
        }

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
