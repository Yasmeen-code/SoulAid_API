<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;


use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{public function store(Request $request)
    {
        $request->validate([
            'UserId' => 'required|exists:users,UserId',
            'Camp_Id' => 'required|exists:campaigns,Camp_Id',
            'comment' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);
    
        $feedback = Feedback::create([
            'UserId' => $request->UserId,
            'Camp_Id' => $request->Camp_Id,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);
    
        return response()->json([
            'message' => 'Feedback submitted successfully.',
            'data' => $feedback,
        ], 201);
    }
    
    
    public function showByCampaign($CampId)
    {
        $feedback = Feedback::where('Camp_Id', $CampId)->with('user')->latest()->get();

        return response()->json($feedback);
    }

    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        $feedback->update($request->only(['comment', 'rating']));

        return response()->json([
            'message' => 'Feedback updated successfully',
            'data' => $feedback
        ]);
    }
}
