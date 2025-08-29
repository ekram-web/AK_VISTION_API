<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ProductPageData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductPageController extends Controller
{
    public function show($category_key)
    {
        // Find or create to ensure it always exists for the admin panel, preventing crashes
        $pageData = ProductPageData::firstOrCreate(
            ['category_key' => $category_key],
            [
                'title' => ucfirst($category_key),
                'intro_text' => 'Manage the content for this page here.'
            ]
        );
        return response()->json($pageData);
    }

    public function update(Request $request, $category_key)
    {
        $pageData = ProductPageData::where('category_key', $category_key)->firstOrFail();

        // Use the validated data directly
        $data = $request->validate([
            'title' => 'required|string',
            'intro_text' => 'required|string',
            'hero_image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        if ($request->hasFile('hero_image')) {
            // Delete the old hero image if it exists
            if ($pageData->hero_image_url) {
                Storage::disk('public')->delete($pageData->hero_image_url);
            }
            // Store the new one and add the path to our data array
            $data['hero_image_url'] = $request->file('hero_image')->store('product_pages', 'public');
        }

        $pageData->update($data);
        return response()->json($pageData);
    }
}
