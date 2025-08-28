<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller {
    public function index(Request $request) {
        $query = FormSubmission::query();
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        return response()->json($query->latest()->get());
    }

    public function store(Request $request) {
        $submission = FormSubmission::create([
            'type' => $request->input('type'),
            'data' => $request->except('type')
        ]);
        // Here you could also trigger an email notification
        return response()->json($submission, 201);
    }

    public function show(FormSubmission $formSubmission) {
        // Mark as read when it's viewed for the first time
        if (!$formSubmission->is_read) {
            $formSubmission->update(['is_read' => true]);
        }
        return response()->json($formSubmission);
    }

    public function destroy(FormSubmission $formSubmission) {
        $formSubmission->delete();
        return response()->json(null, 204);
    }
}
