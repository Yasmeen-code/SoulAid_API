<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Campaign;
use App\Models\DonationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    //========================[OLD]========================//
    /*
    public function index()
    {
        try {
            $donations = Donation::with(['donor', 'campaign', 'donationType'])->get();
            return response()->json([
                'status' => 'success',
                'data' => $donations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(), 
                'trace' => $e->getTraceAsString() 
            ], 500);
        }
    }
    */
    //======================[NEW]=======================//
    public function index()
    {
        try {
            $donations = Donation::with(['donor', 'campaign', 'donationType'])->get();
            return $this->successResponse($donations);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    //========================[OLD]========================//
    /*
    public function indexfordonor()
    {
        try {
            $donorId = Auth::id();

            $donations = Donation::with(['campaign', 'donationType'])
                ->where('Donor_Id', $donorId) 
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $donations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    */
    //======================[NEW]=======================//
    public function indexfordonor()
    {
        try {
            $donorId = Auth::id();
            $donations = Donation::with(['campaign', 'donationType'])
                ->where('Donor_Id', $donorId)
                ->get();

            return $this->successResponse($donations);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    //========================[OLD]========================//
    /*
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'Camp_Id' => 'required|exists:campaigns,Camp_Id',
                'Don_Type_Id' => 'required|exists:donation_types,Don_Type_Id',
                'Amount' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $campaign = Campaign::where('Camp_Id', $request->Camp_Id)->first();
            if (!$campaign) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Campaign not found'
                ], 404);
            }

            $donation = Donation::create([
                'Donor_Id' => Auth::id(),
                'Camp_Id' => $request->Camp_Id,
                'Don_Type_Id' => $request->Don_Type_Id,
                'Amount' => $request->Amount,
                'Donation_Date' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $donation
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    */
    //======================[NEW]=======================//
    public function store(Request $request)
    {
        try {
            $validator = $this->validateStoreRequest($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 422);
            }

            $campaign = $this->findCampaign($request->Camp_Id);
            if (!$campaign) {
                return $this->errorResponse('Campaign not found', 404);
            }

            $donation = Donation::create([
                'Donor_Id' => Auth::id(),
                'Camp_Id' => $request->Camp_Id,
                'Don_Type_Id' => $request->Don_Type_Id,
                'Amount' => $request->Amount,
                'Donation_Date' => now()
            ]);

            return $this->successResponse($donation, 201);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    //========================[OLD]========================//
    /*
    public function show($id)
    {
        try {
            $donation = Donation::with(['user', 'campaign', 'donationType'])
                ->where('Donation_Id', $id)
                ->firstOrFail();
            return response()->json([
                'status' => 'success',
                'data' => $donation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Donation not found'
            ], 404);
        }
    }
    */
    //======================[NEW]=======================//
    public function show($id)
    {
        try {
            $donation = Donation::with(['user', 'campaign', 'donationType'])
                ->where('Donation_Id', $id)
                ->firstOrFail();
            return $this->successResponse($donation);
        } catch (\Exception $e) {
            return $this->errorResponse('Donation not found', 404);
        }
    }

    //========================[OLD]========================//
    /*
    public function update(Request $request, $id)
    {
        try {
            $donation = Donation::where('Donation_Id', $id)->firstOrFail();

            if ($donation->Donor_Id !== Auth::id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'Amount' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $donation->update(['Amount' => $request->Amount]);

            return response()->json([
                'status' => 'success',
                'data' => $donation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update donation'
            ], 500);
        }
    }
    */
    //======================[NEW]=======================//
    public function update(Request $request, $id)
    {
        try {
            $donation = Donation::where('Donation_Id', $id)->firstOrFail();

            if ($donation->Donor_Id !== Auth::id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            $validator = Validator::make($request->all(), [
                'Amount' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 422);
            }

            $donation->update(['Amount' => $request->Amount]);

            return $this->successResponse($donation);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update donation');
        }
    }

    //===============[ Helper Methods ]================//
    private function successResponse($data, $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], $code);
    }

    private function errorResponse($message, $code = 500)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }

    private function validateStoreRequest($request)
    {
        return Validator::make($request->all(), [
            'Camp_Id' => 'required|exists:campaigns,Camp_Id',
            'Don_Type_Id' => 'required|exists:donation_types,Don_Type_Id',
            'Amount' => 'required|numeric|min:0'
        ]);
    }

    private function findCampaign($campId)
    {
        return Campaign::where('Camp_Id', $campId)->first();
    }
}
