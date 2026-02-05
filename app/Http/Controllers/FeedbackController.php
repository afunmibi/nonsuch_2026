<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\LogRequest;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(20);
        return view('feedback.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $pa_code = $request->query('pa_code');
        $policy_no = $request->query('policy_no');
        
        return view('feedback.create', compact('pa_code', 'policy_no'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pa_code' => 'nullable|string',
            'policy_no' => 'required|string',
            'type' => 'required|in:feedback,complaint,review',
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        Feedback::create(array_merge($validated, ['user_id' => auth()->id()]));

        return redirect()->route('feedback.index')->with('success', 'Thank you for your ' . $validated['type'] . '!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('feedback.show', compact('feedback'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Feedback removed.');
    }
}
