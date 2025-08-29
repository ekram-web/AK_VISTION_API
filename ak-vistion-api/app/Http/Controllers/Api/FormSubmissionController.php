<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
    /**
     * Display a listing of the resource. Used by the admin panel.
     * Allows filtering by type, e.g., /api/admin/submissions?type=Sales
     */
    public function index(Request $request)
    {
        $query = FormSubmission::query();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        return response()->json($query->latest()->get());
    }

    /**
     * Store a newly created resource in storage. Used by the public frontend website.
     */
    public function store(Request $request)
    {
        // We can add validation for each type if needed
        // For now, we'll accept the type and all other data

        $submission = FormSubmission::create([
            'type' => $request->input('type'),
            // Store all other fields from the form into the flexible 'data' JSON column
            'data' => $request->except('type')
        ]);

        // Here, you could also add logic to send an email notification to the admin.

        return response()->json([
            'message' => 'Your submission was successful!',
            'submission' => $submission
        ], 201);
    }

    /**
     * Display the specified resource. Marks the submission as read.
     */
    public function show(FormSubmission $submission)
    {
        // Mark as "read" when an admin views it for the first time
        if (!$submission->is_read) {
            $submission->update(['is_read' => true]);
        }

        return response()->json($submission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormSubmission $submission)
    {
        $submission->delete();

        return response()->json(null, 204); // 204 No Content is standard for a successful deletion
    }
}
