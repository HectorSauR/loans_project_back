<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invest\StoreInvestRequest;
use App\Http\Requests\Investor\StoreInvestorRequest;
use App\Http\Requests\Investor\UpdateInvestorRequest;
use App\Models\Invest;
use App\Models\Investor;
use Exception;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Investor::where('status', 1)->get(), 200);
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
        $user = auth()->user();
        $data = $request->all();

        $data['user_id'] = $user->id;

        $available = $data['available'] ?? null;
        unset($data['available']);

        $investor = Investor::create($data);

        if (!is_null($available)) {
            try {
                Invest::createNewInvest([
                    'total' => $available,
                    'investor_id' => $investor->id,
                    'detail' => "Saldo inicial"
                ]);
            } catch (Exception $e) {
                return response()->json(
                    [
                        "detail" => $e->getMessage()
                    ],
                    $e->getCode()
                );
            }
        }

        return response()->json($investor, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $investor = Investor::where('id', $id)->where('user_id', auth()->user()->id)->first();

        if (is_null($investor)) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json($investor, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvestorRequest $request, int $id)
    {
        $data = $request->all();
        $investor = Investor::findOrFail($id);

        $investor->update($data);

        return response()->json($investor, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $investor = Investor::findOrFail($id);

        $investor->delete();

        return response()->json(null, 204);
    }

    public function reactivateInvestor(int $id)
    {
        $investor = Investor::findOrFail($id);
        $investor->status = 1;
        $this->save();
    }

    public function addMovement(StoreInvestRequest $request, int $id)
    {
        $data = $request->all();

        $data["investor_id"] = $id;

        try {
            $invest = Invest::createNewInvest($data);
        } catch (Exception $e) {
            return response()->json(
                [
                    "detail" => $e->getMessage()
                ],
                $e->getCode()
            );
        }

        return response()->json($invest, 200);
    }

    public function updateMovement(StoreInvestRequest $request, int $investorId, int $movementId)
    {
        $data = $request->all();

        $investor = Investor::findOrFail($investorId);

        $movement = $investor->invests->where('id', $movementId)->first();

        if (!$movement) {
            return response()->json([
                "detail" => "No hay relación entre el movimiento y el inversor"
            ], 404);
        }

        try {
            $movement->update($data);
        } catch (Exception $e) {
            return response()->json(
                [
                    "detail" => $e->getMessage()
                ],
                $e->getCode()
            );
        }

        return response()->json($movement, 200);
    }
}
