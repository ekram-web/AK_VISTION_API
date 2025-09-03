<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\FeaturedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeaturedItemController extends Controller {
    public function index() { return response()->json(FeaturedItem::orderBy('id', 'desc')->get()); }

    public function store(Request $request) {
        $data = $request->validate(['title' => 'required', 'description' => 'required', 'image' => 'nullable|image']);
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('homepage/featured', 'public');
        }
        $item = FeaturedItem::create($data);
        return response()->json($item, 201);
    }

    public function update(Request $request, FeaturedItem $featuredItem) {
        $data = $request->validate(['title' => 'required', 'description' => 'required', 'image' => 'nullable|image']);
        if ($request->hasFile('image')) {
            if ($featuredItem->image_url) { Storage::disk('public')->delete($featuredItem->image_url); }
            $data['image_url'] = $request->file('image')->store('homepage/featured', 'public');
        }
        $featuredItem->update($data);
        return response()->json($featuredItem);
    }

    public function destroy(FeaturedItem $featuredItem) {
        if ($featuredItem->image_url) { Storage::disk('public')->delete($featuredItem->image_url); }
        $featuredItem->delete();
        return response()->json(null, 204);
    }
}
