<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DonationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonationTypeController extends Controller
{
    public function index()
    {
        try {
            $types = DonationType::all();
            return response()->json([
                'status' => 'success',
                'data' => $types
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch donation types'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'Type_Name' => 'required|string|max:255',
                'Description' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $type = DonationType::create($request->all());

            return response()->json([
                'status' => 'success',
                'data' => $type
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create donation type'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $type = DonationType::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $type
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Donation type not found'
            ], 404);
        }
    }
}