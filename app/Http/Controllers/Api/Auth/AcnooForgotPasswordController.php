<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Mail\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class AcnooForgotPasswordController extends Controller
{
    public function sendResetCode(Request $request) : JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);
        
        $code = random_int(100000,999999);
        $expire = now()->addHour();
        $user = User::where('email',$request->email)->first();
        //return $user;
        $user->update(['remember_token' => $code, 'email_verified_at' => $expire]);
        
        
        $data = [
            'code' => $code
        ];

        try {
            if (env('QUEUE_MAIL')) {
                Mail::to($request->email)->queue(new PasswordReset($data));
            } else {
                Mail::to($request->email)->send(new PasswordReset($data));
            }
            return response()->json([
                'message' => 'Şifre sıfırlama kodu e-posta adresinize gönderildi.',
            ]);
            
        } catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'code' => 'required|integer',
            'email' => 'required|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->remember_token == $request->code) {
            if ($user->email_verified_at > now()) {
                return response()->json([
                    'message' => __('Kod doğrulandı.')
                ]);
            } else {
                return response()->json([
                    'error' => __('Doğrulama kodunun süresi doldu.')
                ], 400);
            }
        } else {
            return response()->json([
                'error' => __('Geçersiz Kod!')
            ], 404);
        }
    }

    public function resetPassword(Request $request) : JsonResponse
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required|exists:users,email',
            'password_confirmation' => ['required'],
            'password' => ['required', 'confirmed', 'min:4'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->remember_token == $request->code) {
            if ($user->email_verified_at > now()) {

                $user->update([
                    'remember_token' => NULL,
                    'password' => bcrypt($request->password),
                ]);

                return response()->json([
                    'message' => 'Şifreniz değiştirildi!',
                ], 200);
            } else {
                return response()->json([
                    'error' => __('Doğrulama kodunun süresi doldu.')
                ], 400);
            }
        } else {
            return response()->json([
                'error' => __('Geçersiz Kod!')
            ], 404);
        }
    }
}
