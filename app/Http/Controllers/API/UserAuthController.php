<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Factories\UserFactory;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $user = User::where('Email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->Password)) {
                $token = $user->createToken('auth-token')->plainTextToken;

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'id' => $user->UserId,
                        'name' => $user->Name,
                        'email' => $user->Email,
                        'address' => $user->Address,
                        'user_type' => $user->UserType,
                        'image' => $user->Image,
                    ],
                    'token' => $token
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password'
            ], 401);

        } catch (\Exception $e) {
            Log::error('User login error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Login failed'
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,Email|unique:admins,Email',
                'password' => 'required|min:6',
                'address' => 'nullable|string',
                'user_type' => 'required|in:Donor,Acceptor',
                'image' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $factory = UserFactory::createFactory($request->user_type);
            $user = $factory->create($request->all());


            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $user->UserId,
                    'name' => $user->Name,
                    'email' => $user->Email,
                    'user_type' => $request->user_type
                ],
                'token' => $token
            ], 201);

        } catch (\Exception $e) {
            Log::error('User registration error: ' . $e->getMessage());
            Log::error('Full Exception: ', ['exception' => $e]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() 
            ], 500);
        }
        
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }



    
}



