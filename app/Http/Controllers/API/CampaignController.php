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
    public function update(Request $request, $id)
{
    try {
        $campaign = Campaign::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'CampName' => 'required|string|max:255',
            'Description' => 'required|string',
            'StartDate' => 'required|date',
            'EndDate' => 'required|date|after:StartDate',
            'Image' => 'nullable|string',
            'Admin_Id' => 'required|exists:admins,Admin_Id',
            'Don_Type_Id' => 'required|exists:donation_types,Don_Type_Id',
            'Amount' => 'required|numeric|min:0',
            'Address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $campaign->CampName = $request->input('CampName');
        $campaign->Description = $request->input('Description');
        $campaign->StartDate = $request->input('StartDate');
        $campaign->EndDate = $request->input('EndDate');
        $campaign->Image = $request->input('Image');
        $campaign->Admin_Id = $request->input('Admin_Id');
        $campaign->Don_Type_Id = $request->input('Don_Type_Id');
        $campaign->Amount = $request->input('Amount');
        $campaign->Address = $request->input('Address');
        
        $saved = $campaign->save();

        if (!$saved) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save the updated campaign data'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign updated successfully',
            'data' => $campaign
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update campaign',
            'error_details' => $e->getMessage(),
        ], 500);
    }
}
public function destroy($id)
{
    $campaign = Campaign::find($id);

    if (!$campaign) {
        return response()->json([
            'status' => 'error',
            'message' => 'Campaign not found.',
        ], 404);
    }

    $campaign->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Campaign deleted successfully.',
    ]);
}


public function edit($id)
{
    try {
        $campaign = Campaign::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $campaign,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Campaign not found',
            'error_details' => $e->getMessage(),
        ], 404);
    }
}

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
    
            $campaign = CampaignFactory::createCampaign($request->input('Don_Type_Id'), $request->all());
    
            return response()->json([
                'status' => 'success',
                'data' => $campaign
            ], 201);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create campaign',
                'error_details' => $e->getMessage(), 
            ], 500);
        }
    }
    
}
