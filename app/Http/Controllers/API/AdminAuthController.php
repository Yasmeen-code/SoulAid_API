<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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

            $admin = Admin::where('Email', $request->email)->first();

            if ($admin && Hash::check($request->password, $admin->Password)) {
                $token = $admin->createToken('auth-token', ['admin'])->plainTextToken;

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
public function destroy($UserId)
{
    $user = User::find($UserId);

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'user not found.',
        ], 404);
    }

    $user->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'User deleted successfully.',
    ]);
}


}
