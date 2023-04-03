<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassRequest;
use App\Http\Requests\ResetPassRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function forgotPass(ForgotPassRequest $request) {
        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            $status = ($status === Password::RESET_LINK_SENT) ? 200 : 500;

            return response()->json(['status' => $status]);
        }catch (\Exception $e){
            return response()->json(['status' => 500, 'err' => $e]);
        }
    }

    public function tokenReset($token): \Illuminate\Http\JsonResponse
    {
        return response()->json(['token' => $token]);
    }

    public function resetPass (ResetPassRequest $request) {
        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            $status = ($status === Password::PASSWORD_RESET) ? 200 : 500;

            return response()->json(['status' => $status]);
        }catch (\Exception $e){
            return response()->json(['status' => 500, 'err' => $e]);
        }
    }
}
