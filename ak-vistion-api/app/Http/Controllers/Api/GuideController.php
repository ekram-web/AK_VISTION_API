<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Guide;
use Illuminate\Http\Request;

class GuideController extends Controller {
    public function index() { return response()->json(Guide::all()); }
    public function store(Request $request) {
        $data = $request->validate(['title' => 'required', 'category' => 'nullable', 'instructions' => 'nullable']);
        $guide = Guide::create($data);
        return response()->json($guide, 201);
    }
    public function update(Request $request, Guide $guide) {
        $data = $request->validate(['title' => 'required', 'category' => 'nullable', 'instructions' => 'nullable']);
        $guide->update($data);
        return response()->json($guide);
    }
    public function destroy(Guide $guide) { $guide->delete(); return response()->json(null, 204); }
}
