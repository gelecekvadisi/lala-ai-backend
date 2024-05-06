<?php

namespace App\Http\Controllers\Api;

use App\Models\CreditsEarning;
use Throwable;
use App\Models\BuyCredits;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AcnooBuyCreditsContrller extends Controller
{
    public function index()
    {
        $buy_credits = BuyCredits::whereStatus(1)->latest()->get();
        return response()->json([
            'status' => 200,
            'message' => __('Data fetched successfully.'),
            'data' => $buy_credits
        ]);
    }

    public function show($id)
    {
        $credit_plan = BuyCredits::find($id);
        if (!$credit_plan) {
            return response()->json([
                'status' => 404,
                'message' => __('Buy credit plan not found.'),
            ], 404);
        }

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $user->update([
                'credits' => $user->credits + $credit_plan->reward
            ]);

            $credits = CreditsEarning::create([
                'user_id' => auth()->id(),
                'platform' => "Buy credits",
                'price' => $credit_plan->price,
                'credits' => $credit_plan->reward,
            ]);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => $credits->credits . ' Credits added to your balance.',
                'data' => $credits,
            ]);

        } catch (Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => __('Something was wrong, Please contact with author.')
            ], 403);
        }
    }
}
