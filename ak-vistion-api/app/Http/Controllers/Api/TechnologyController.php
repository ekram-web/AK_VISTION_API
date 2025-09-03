<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnologyController extends Controller {
    public function index() { return response()->json(Technology::all()); }

    public function store(Request $request) {
        $data = $request->validate([ 'name' => 'required', 'shortDesc' => 'required', 'longDesc' => 'required', 'image' => 'nullable|image' ]);
        $dbData = ['name' => $data['name'], 'short_desc' => $data['shortDesc'], 'long_desc' => $data['longDesc']];
        if ($request->hasFile('image')) { $dbData['image_url'] = $request->file('image')->store('technologies', 'public'); }
        $technology = Technology::create($dbData);
        return response()->json($technology, 201);
    }

    public function update(Request $request, Technology $technology) {
        $data = $request->validate([ 'name' => 'required', 'shortDesc' => 'required', 'longDesc' => 'required', 'image' => 'nullable|image' ]);
        $dbData = ['name' => $data['name'], 'short_desc' => $data['shortDesc'], 'long_desc' => $data['longDesc']];
        if ($request->hasFile('image')) {
            if ($technology->image_url) { Storage::disk('public')->delete($technology->image_url); }
            $dbData['image_url'] = $request->file('image')->store('technologies', 'public');
        }
        $technology->update($dbData);
        return response()->json($technology);
    }

    public function destroy(Technology $technology) {
        if ($technology->image_url) { Storage::disk('public')->delete($technology->image_url); }
        $technology->delete();
        return response()->json(null, 204);
    }
}
