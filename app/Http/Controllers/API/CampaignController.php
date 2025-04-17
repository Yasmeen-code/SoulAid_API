<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Factories\CampaignFactory; 
use App\Prototypes\CampaignPrototype;

class CampaignController extends Controller
{
    public function index()
    {
        try {
            $campaigns = Campaign::all();
            return response()->json([
                'status' => 'success',
                'data' => $campaigns
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch campaigns'
            ], 500);
        }
    }
    public function cloneCampaign($id)
    {
        try {
            $original = Campaign::findOrFail($id);
    
            $cloned = CampaignPrototype::clone($original);
    
            $cloned->StartDate = now();
            $cloned->EndDate = now()->addDays(30); 
            $cloned->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Campaign cloned successfully',
                'data' => $cloned
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to clone campaign'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'CampName' => 'required|string|max:255',
                'Description' => 'required|string',
                'StartDate' => 'required|date',
                'EndDate' => 'required|date|after:StartDate',
                'Image' => 'nullable|string',
                'Admin_Id' => 'required|exists:admins,Admin_Id',
                'Don_Type_Id' => 'required|exists:donation_types,Don_Type_Id',
                'Amount' => 'required|numeric|min:0',
                'Address' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $campaign = CampaignFactory::createCampaign($request->input('type'), $request->all());

            return response()->json([
                'status' => 'success',
                'data' => $campaign
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create campaign'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $campaign = Campaign::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $campaign
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Campaign not found'
            ], 404);
        }
    }
}
