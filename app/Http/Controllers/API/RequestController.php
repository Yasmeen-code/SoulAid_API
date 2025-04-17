<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RequestModel;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $acceptorId = Auth::id();

        if (!$this->isAcceptor(Auth::user())) {
            return response()->json(['message' => 'User is not an Acceptor'], 403);
        }

        $newRequest = RequestModel::create([
            'Don_Type_Id' => $request->Don_Type_Id,
            'Amount' => $request->Amount,
            'description' => $request->description,
            'Status' => 'Pending',
            'Date' => now(),
            'Level_Of_Need' => $request->Level_Of_Need,
            'Acceptor_Id' => $acceptorId,
        ]);

        return response()->json(['message' => 'Request created successfully', 'request' => $newRequest], 201);
    }

    private function isAcceptor($user)
    {
        return $user->UserType === 'Acceptor'; 
    }
    
    public function index()
    {
        if (Auth::user()->UserType !== 'Admin') {
            return response()->json(['message' => 'Unauthorized: Only admins can view all requests'], 403);
        }

        $requests = RequestModel::all();

        return response()->json([
            'status' => 'success',
            'data' => $requests
        ]);
    }

    public function showUserRequests()
    {
        $user = Auth::user();
        $acceptorId = Auth::id();

        if ($user->UserType !== 'Acceptor') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: Only acceptors can view their requests'
            ], 403);
        }

        $requests = RequestModel::where('Acceptor_Id',$acceptorId)->get();
        if ($requests->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No requests found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Requests retrieved successfully',
            'data' => $requests
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $requestData = $request->validate([
            'Don_Type_Id' => 'integer',
            'Amount' => 'numeric',
            'description' => 'string',
            'Status' => 'string',
            'Date' => 'date',
            'Level_Of_Need' => 'string',
        ]);

        $requestItem = RequestModel::findOrFail($id);

        if ($user->UserType !== 'Acceptor' || $requestItem->Acceptor_Id !== $user->id) {
            return response()->json(['message' => 'Unauthorized: You can only edit your own requests'], 403);
        }

        $requestItem->update($requestData);

        return response()->json([
            'status' => 'success',
            'data' => $requestItem
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $requestItem = RequestModel::findOrFail($id);

        if ($user->UserType !== 'Acceptor' || $requestItem->Acceptor_Id !== $user->id) {
            return response()->json(['message' => 'Unauthorized: You can only delete your own requests'], 403);
        }

        $requestItem->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Request deleted successfully'
        ]);
    }
}
