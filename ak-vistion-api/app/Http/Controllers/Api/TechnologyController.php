<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnologyController extends Controller {
    public function index() { return response()->json(Technology::all()); }

    public function store(Request $request) {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('technologies', 'public');
            $data['image_url'] = $path;
        }
        $technology = Technology::create($data);
        return response()->json($technology, 201);
    }

    public function show(Technology $technology) { return response()->json($technology); }

    public function update(Request $request, Technology $technology) {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            if ($technology->image_url) { Storage::disk('public')->delete($technology->image_url); }
            $path = $request->file('image')->store('technologies', 'public');
            $data['image_url'] = $path;
        }
        $technology->update($data);
        return response()->json($technology);
    }

    public function destroy(Technology $technology) {
        if ($technology->image_url) { Storage::disk('public')->delete($technology->image_url); }
        $technology->delete();
        return response()->json(null, 204);
    }
}
