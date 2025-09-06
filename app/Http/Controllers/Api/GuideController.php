<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GuideController extends Controller
{
    public function index()
    {
        return response()->json(Guide::latest()->get());
    }

    public function store(Request $request)
    {
        // 1. Validate the text fields
        $data = $request->validate([
            'title' => 'required|string',
            'category' => 'nullable|string',
            'instructions' => 'nullable|string',
        ]);

        // 2. Handle the file uploads separately
        $pdfPaths = [];
        if ($request->hasFile('pdfs')) {
            foreach ($request->file('pdfs') as $pdfFile) {
                // Ensure the uploaded file is valid before processing
                $validatedFile = Validator::make(['pdf' => $pdfFile], ['pdf' => 'required|file|mimes:pdf|max:10240']);
                if ($validatedFile->fails()) {
                    continue; // Skip invalid files
                }

                $path = $pdfFile->store('guides/pdfs', 'public');
                $pdfPaths[] = [
                    'path' => $path,
                    'name' => $pdfFile->getClientOriginalName()
                ];
            }
        }

        // 3. Add the JSON-encoded file paths to the correct database column
        $data['pdf_links'] = json_encode($pdfPaths);

        // 4. Create the record
        $guide = Guide::create($data);
        return response()->json($guide, 201);
    }

    public function show(Guide $guide)
    {
        return response()->json($guide);
    }

    public function update(Request $request, Guide $guide)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'category' => 'nullable|string',
            'instructions' => 'nullable|string',
            // Add validation for new PDFs if you allow updates
        ]);

        // This is a simplified update. A full update would also handle adding/removing individual PDFs.
        $guide->update($data);
        return response()->json($guide);
    }

    public function destroy(Guide $guide)
    {
        if ($guide->pdf_links) {
            $pdfLinksArray = json_decode($guide->pdf_links, true);
            if (is_array($pdfLinksArray)) {
                foreach ($pdfLinksArray as $link) {
                    if (isset($link['path'])) {
                        Storage::disk('public')->delete($link['path']);
                    }
                }
            }  
        }
        $guide->delete();
        return response()->json(null, 204);
    }
}
