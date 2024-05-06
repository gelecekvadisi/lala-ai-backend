<?php

namespace App\Http\Controllers\Api;

use App\Models\Plan;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AcnooSubscribesController extends Controller
{
    public function index()
    {
        $subscribes = Subscribe::where('user_id', auth()->id())->latest()->get();
        return response()->json([
            'status' => 200,
            'message' => __('Data fetched successfully.'),
            'data' => $subscribes
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);
        
        DB::beginTransaction();
        try {

            $user = auth()->user();
            $plan = Plan::findOrFail($request->plan_id);
            $has_free_subscriptions = Subscribe::where('price', '<=', 0)->first();

            if ($plan->price <= 0 && $has_free_subscriptions) {
                return response()->json([
                    'status' => 406,
                    'message' => __('Sorry, you cannot subscribe to a free plan again.'),
                ], 406);
            }
            
            if ($user->will_expire > now() && $request->plan_id == $user->plan_id) {
                return response()->json([
                    'status' => 409,
                    'message' => __('You have already subscribed to this plan. Please try again after - '. formatted_date($user->will_expire)),
                ], 400);
            }

            $duration_in_days = $plan->duration == 'yearly' ? 365 : ($plan->duration == '6_monthly' ? 180 : ($plan->duration == '3_monthly' ? 90 : ($plan->duration == 'monthly' ? 30 : ($plan->duration == '15_days' ? 15 : ($plan->duration == 'weekly' ? 7 : 0)))));

            $subscribe = Subscribe::create([
                'plan_id' => $plan->id,
                'user_id' => $user->id,
                'price' => $plan->price,
                'will_expire' => now()->addDays($duration_in_days),
            ]);
            
            $user->update([
                'plan_id' => $plan->id,
                'will_expire' => now()->addDays($duration_in_days),
            ]);

            sendNotification($subscribe->id, route('admin.subscribers.index', ['id' => $subscribe->id]), __('New plan subscribed.'), $user);

            DB::commit();
            return response()->json([
                'message' => __('Subscription enrolled successfully.'),
                'data' => $subscribe,
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(__('Something was wrong, Please contact with author.'), 403);
        }
    }

    public function cancel()
    {
        $user = auth()->user();
        $user->update([
            'plan_id' => null,
            'will_expire' => null,
        ]);

        return response()->json([
            'status' => 200,
            'message' => __('Your current subscription has been canceled.'),
        ]);
    }
}
