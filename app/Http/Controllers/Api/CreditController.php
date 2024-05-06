<?php

namespace App\Http\Controllers\Api;

use App\Models\Generate;
use Illuminate\Http\Request;
use App\Models\CreditsEarning;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CreditController extends Controller
{
    public function index(Request $request)
    {
        if ($request->type) {
            if ($request->type == 'earnings') {

                $data = CreditsEarning::where('user_id', auth()->id())->latest()->get();

            } elseif ($request->type == 'costings') {

                $data = Generate::select('type', 'cost_credits', 'title', 'created_at')->whereUserId(auth()->id())->latest()->get();

            } else {
                return response()->json([
                    'status' => 400,
                    'message' => __('Please provide a valid type.'),
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => __('Data fetched successfully.'),
                'data' => $data,
            ]);

        } else {
            return response()->json([
                'status' => 400,
                'message' => __('Please provide a type.'),
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string',
            'credits' => 'required|numeric|gt:0',
        ]);

        DB::beginTransaction();
        try {

            $credits = CreditsEarning::create($request->all() + [
                'user_id' => auth()->id()
            ]);

            $user = auth()->user();
            $user->update([
                'credits' => $user->credits + $request->credits
            ]);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => __('Credit added successfully.'),
                'data' => $credits,
            ]);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json( __('Something was wrong, Please contact with author.'), 403);
        }
    }
}