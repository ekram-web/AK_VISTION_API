<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\FeaturedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeaturedItemController extends Controller
{
    public function index()
    {
        return response()->json(FeaturedItem::orderBy('id', 'desc')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('homepage/featured', 'public');
        } else {
            // Set a default or empty value if no image is uploaded
            $data['image_url'] = '';
        }

        $item = FeaturedItem::create($data);
        return response()->json($item, 201);
    }

    // --- THIS IS THE FINAL, CORRECTED UPDATE METHOD ---
    public function update(Request $request, FeaturedItem $featuredItem)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Check if a new image file is present in the request
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($featuredItem->image_url) {
                Storage::disk('public')->delete($featuredItem->image_url);
            }
            // Store the new image and update the path
            $data['image_url'] = $request->file('image')->store('homepage/featured', 'public');
        }
        // If no new image is uploaded, the existing 'image_url' is preserved,
        // and only the other text fields are updated.

        $featuredItem->update($data);
        return response()->json($featuredItem);
    }

    public function destroy(FeaturedItem $featuredItem)
    {
        if ($featuredItem->image_url) {
            Storage::disk('public')->delete($featuredItem->image_url);
        }
        $featuredItem->delete();
        return response()->json(null, 204);
    }
}
