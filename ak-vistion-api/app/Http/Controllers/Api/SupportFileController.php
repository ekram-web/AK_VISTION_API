<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SupportFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // This is the key for the frontend filter. It will only return
        // files of the requested type (e.g., Firmware, SDK, or Software).
        $query = SupportFile::query();
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        return response()->json($query->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Firmware,SDK,Software',
            'product_model' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'description' => 'nullable|string',
            'file' => 'required|file|max:51200' // 50MB Max
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('support-files/' . strtolower($data['type']), 'public');
            $data['file_url'] = $path;
        }

        unset($data['file']);
        $file = SupportFile::create($data);
        return response()->json($file, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportFile $supportFile)
    {
        return response()->json($supportFile);
    }

    /**
     * Update the specified resource in storage.
     * This is the final, corrected version.
     */
    public function update(Request $request, SupportFile $supportFile)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Firmware,SDK,Software',
            'product_model' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:51200'
        ]);

        if ($request->hasFile('file')) {
            if ($supportFile->file_url) {
                Storage::disk('public')->delete($supportFile->file_url);
            }
            $path = $request->file('file')->store('support-files/' . strtolower($supportFile->type), 'public');
            $data['file_url'] = $path;
        }

        unset($data['file']);

        $supportFile->update($data);
        return response()->json($supportFile);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportFile $supportFile)
    {
        if ($supportFile->file_url) {
            Storage::disk('public')->delete($supportFile->file_url);
        }
        $supportFile->delete();
        return response()->json(null, 204);
    }
}
