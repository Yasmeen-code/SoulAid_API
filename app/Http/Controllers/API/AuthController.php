<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Factories\UserFactory;

class AuthController extends Controller
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

            // استخدام دالة مشتركة للتحقق من المستخدم
            $user = $this->authenticateUser($request->email, $request->password);
            if ($user) {
                return $this->generateSuccessResponse($user, 'user');
            }

            $admin = $this->authenticateAdmin($request->email, $request->password);
            if ($admin) {
                return $this->generateSuccessResponse($admin, 'admin');
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password'
            ], 401);
    
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during login: ' . $e->getMessage()
            ], 500);
        }
    }

    // دالة مشتركة للتحقق من المستخدم
    private function authenticateUser($email, $password)
    {
        $user = User::where('Email', $email)->first();
        if ($user && Hash::check($password, $user->Password)) {
            return $user;
        }
        return null;
    }

    // دالة مشتركة للتحقق من المسؤول
    private function authenticateAdmin($email, $password)
    {
        $admin = Admin::where('Email', $email)->first();
        if ($admin && Hash::check($password, $admin->Password)) {
            return $admin;
        }
        return null;
    }

    // دالة لرد النجاح المشترك للمستخدم والإدمن
    private function generateSuccessResponse($user, $userType)
    {
        $token = $user->createToken('auth-token')->plainTextToken;
        $data = [
            'status' => 'success',
            'user_type' => $userType,
            'data' => [
                'id' => $user->{$userType == 'user' ? 'UserId' : 'Admin_Id'},
                'name' => $user->Name,
                'email' => $user->Email,
                'address' => $user->Address ?? null,
                'user_type' => $user->UserType ?? null,
                'image' => $user->Image ?? null
            ],
            'token' => $token
        ];
        return response()->json($data);
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
                    'id' => $user->id,
                    'name' => $user->Name,
                    'email' => $user->Email,
                    'user_type' => $request->user_type
                ],
                'token' => $token
            ], 201);

        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed'
            ], 500);
        }
    }
}
