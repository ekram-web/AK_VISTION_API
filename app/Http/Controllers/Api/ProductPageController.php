<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductPageData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductPageController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($category_key)
    {
        // Find the page by its key, or create a default one if it doesn't exist
        $pageData = ProductPageData::firstOrCreate(
            ['category_key' => $category_key],
            [
                'title' => ucfirst($category_key),
                'intro_text' => 'Manage the content for this page here.',
                'hero_image_url' => null
            ]
        );
        return response()->json($pageData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $category_key)
    {
        $pageData = ProductPageData::where('category_key', $category_key)->firstOrFail();

        // 1. Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'intro_text' => 'required|string',
            'hero_image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        // 2. Create a clean array for the database with only the text fields
        $dataToUpdate = [
            'title' => $validatedData['title'],
            'intro_text' => $validatedData['intro_text'],
        ];

        // 3. Handle the file upload separately
        if ($request->hasFile('hero_image')) {
            // Delete the old hero image if it exists to save space
            if ($pageData->hero_image_url) {
                Storage::disk('public')->delete($pageData->hero_image_url);
            }
            // Store the new one and add the file path to our data array
            $dataToUpdate['hero_image_url'] = $request->file('hero_image')->store('product_pages', 'public');
        }

        // 4. Now, update the database record with the clean data
        $pageData->update($dataToUpdate);

        return response()->json($pageData);
    }
}
