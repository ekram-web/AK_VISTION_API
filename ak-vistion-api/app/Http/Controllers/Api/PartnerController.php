<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller {
    public function index() { return response()->json(Partner::all()); }

    public function store(Request $request) {
        $data = $request->validate(['name' => 'required|string|max:255', 'logo' => 'nullable|image']);
        if ($request->hasFile('logo')) {
            $data['logo_url'] = $request->file('logo')->store('partners', 'public');
        }
        $partner = Partner::create($data);
        return response()->json($partner, 201);
    }

    public function update(Request $request, Partner $partner) {
        $data = $request->validate(['name' => 'required|string|max:255', 'logo' => 'nullable|image']);
        if ($request->hasFile('logo')) {
            if ($partner->logo_url) { Storage::disk('public')->delete($partner->logo_url); }
            $data['logo_url'] = $request->file('logo')->store('partners', 'public');
        }
        $partner->update($data);
        return response()->json($partner);
    }

    public function destroy(Partner $partner) {
        if ($partner->logo_url) { Storage::disk('public')->delete($partner->logo_url); }
        $partner->delete();
        return response()->json(null, 204);
    }
}
