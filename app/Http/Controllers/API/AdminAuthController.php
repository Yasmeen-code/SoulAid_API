<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Factories\UserFactory;
use App\Factories\AdminFactory;
use App\Http\Requests\AdminLoginRequest;


class AdminAuthController extends Controller
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

            // العثور على الـ Admin بناءً على البريد الإلكتروني
            $admin = Admin::where('Email', $request->email)->first();

            // التحقق من كلمة المرور باستخدام Hash::check
            if ($admin && Hash::check($request->password, $admin->Password)) {
                // إنشاء التوكن باستخدام Sanctum
                $token = $admin->createToken('auth-token')->plainTextToken;

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'id' => $admin->Admin_Id,
                        'name' => $admin->Name,
                        'email' => $admin->Email,
                        'role' => "admin"
                    ],
                    'token' => $token
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password'
            ], 401);

        } catch (\Exception $e) {
            Log::error('Admin login error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Login failed'
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
    
    public function getUsers(Request $request)
    {
        try {
            $admin = auth('admin')->user();
    
            if (!$admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 403);
            }
    
            $users = User::all();
    
            // سجل بيانات الـ users للتحقق من صحتها
            Log::info('Fetched users:', $users->toArray()); 
    
            return response()->json([
                'status' => 'success',
                'data' => $users
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch users'
            ], 500);
        }
    }
    
    
}
