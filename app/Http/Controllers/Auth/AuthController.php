<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function viewLogin(){
        if (Auth::user()){
            return redirect()->route('users.list');
        }
        return view('auth.login');
    }

    public function viewRegister(){
//        return view('auth.register');
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);

            $user = User::where('email', $request->get('email'))->first();

            if (!$user || !Hash::check($request->get('password'), $user->password, [])) {
                throw new \Exception('Error in Login');
            }

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized',
                    'data' => $credentials,
                ]);
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);

        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }

    public function logout(){
        Auth::user()->tokens()->delete(); // xoa tat ca token cua user
//        Auth::user()->currentAccessToken()->delete(); // xoa token hien tai
        auth()->guard('web')->logout();

        return response()->json([
            'status_code' => 200,
        ]);
    }
}
