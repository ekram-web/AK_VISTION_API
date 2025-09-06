<?php

namespace App\Http\Controllers\Api; // <-- CORRECTED NAMESPACE

use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LegalPageController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($page_key)
    {
        // Find the page by its key, or create a default one if it doesn't exist.
        $page = LegalPage::firstOrCreate(
            ['page_key' => $page_key],
            [
                'content' => "<h1>".ucfirst(str_replace('-', ' ', $page_key))."</h1><p>Edit this content.</p>",
                'last_updated' => now()
            ]
        );
        return response()->json($page);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $page_key)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find the page or create it if it somehow doesn't exist yet.
        $page = LegalPage::updateOrCreate(
            ['page_key' => $page_key],
            [
                'content' => $request->input('content'),
                'last_updated' => now()
            ]
        );

        return response()->json([
            'message' => ucfirst(str_replace('-', ' ', $page_key)) . ' page updated successfully!',
            'page' => $page
        ]);
    }
}
