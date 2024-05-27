<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Plan;
use App\Models\User;
use App\Models\Subscribe;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\NewAccessToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    use HasUploader;

    public function registration(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:250',
            'phone'  => 'nullable|min:5|max:15',
            'password' => 'required|min:6|max:100',
            'email' => 'required|email|unique:users,email',
            'image' => 'nullable|image|mimes:jpeg,png,gif|dimensions:max_width=2000,max_height=2000|max:1048',
        ]);

        DB::beginTransaction();
        try {

            $free_plan = Plan::where('price', '<=', 0)->first();
            if ($free_plan) {
                $duration_in_days = $free_plan->duration == 'yearly' ? 365 : ($free_plan->duration == '6_monthly' ? 180 : ($free_plan->duration == '3_monthly' ? 90 : ($free_plan->duration == 'monthly' ? 30 : ($free_plan->duration == '15_days' ? 15 : ($free_plan->duration == 'weekly' ? 7 : 0)))));
                $duration_in_days = now()->addDays($duration_in_days);
            }

            $user = User::create($request->except('password', 'image') + [
                'plan_id' => $free_plan->id ?? null,
                'password' => bcrypt($request->password),
                'will_expire' => $duration_in_days ?? null,
                'image' => $request->image ? $this->upload($request, 'image') : null,
                'credits' => 100,
            ]);

            if ($free_plan) {
                Subscribe::create([
                    'user_id' => $user->id,
                    'plan_id' => $free_plan->id,
                    'price' => $free_plan->price,
                    'will_expire' => $duration_in_days ?? null,
                ]);
            }

            $accessToken = $user->createToken('createToken');
            $this->setAccessTokenExpiration($accessToken);

            $data = [
                'user_id' => $user->id,
                'token_type' => 'Bearer',
                'token' => $user->createToken('maanRocketApp')->plainTextToken,
            ];

            sendNotification($user->id, route('admin.users.index', ['id' => $user->id, 'type' => 'user']), __('New user registerd.'), $user);

            DB::commit();
            return response()->json([
                'data' => $data,
                'message' => 'Registration Successfully.'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(__('Something was wrong, Please contact with author.'), 403);
        }
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'email' => 'required|email',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            $user = auth()->user();
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['user_id'] = $user->id;
            $data['token'] = $user->createToken('createToken')->plainTextToken;

            $accessToken = $user->createToken('createToken');
            $this->setAccessTokenExpiration($accessToken);

            return response()->json([
                'data' => $data,
                'message' => 'User login successfully!',
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid email or password!'
            ], 404);
        }
    }

    protected function setAccessTokenExpiration(NewAccessToken $accessToken)
    {
        $expiration = now()->addMinutes(Config::get('sanctum.expiration'));

        DB::table('personal_access_tokens')
            ->where('id', $accessToken->accessToken->id)
            ->update(['expires_at' => $expiration]);
    }

    public function maanSignOut() : JsonResponse
    {
        if (auth()->user()->tokens()) {
            auth()->user()->tokens()->delete();

            return response()->json([
                'message' => __('Sign out successfully'),
            ]);
        } else {
            return response()->json([
                'message' => __('Unauthorized'),
            ], 401);
        }
    }

    public function refreshToken()
    {
        if (auth()->user()->tokens()) {
            
            auth()->user()->currentAccessToken()->delete();
            $data['token'] = auth()->user()->createToken('createToken')->plainTextToken;
            return response()->json($data);

        } else {
            return response()->json([
                'message' => __('Unauthorized'),
            ], 401);
        }
    }
}

