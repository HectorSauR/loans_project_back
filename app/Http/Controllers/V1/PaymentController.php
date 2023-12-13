<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Http\Resources\V1\Payment\PaymentCollection;
use App\Http\Resources\V1\Payment\PaymentResource;
use App\Models\Payment;
use Exception;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return response()->json(new PaymentCollection($user->payments), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $data = $request->all();
        try {
            $payment = Payment::createNewPayment($data);
        } catch (Exception $e) {
            return response()->json(
                [
                    "detail" => $e->getMessage()
                ],
                $e->getCode()
            );
        }

        return response()->json(new PaymentResource($payment), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $payment = Payment::findOrFail($id);

        $payment->delete();

        return response()->json([
            "message" => "pago eliminado con exitos!"
        ], 200);
    }
}
