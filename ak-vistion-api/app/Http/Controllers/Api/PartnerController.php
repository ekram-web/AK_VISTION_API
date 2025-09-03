<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        return response()->json(Partner::all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $dataToCreate = ['name' => $validatedData['name']];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('partners', 'public');
            $dataToCreate['logo_url'] = $path;
        }

        $partner = Partner::create($dataToCreate);
        return response()->json($partner, 201);
    }

    public function update(Request $request, Partner $partner)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $dataToUpdate = ['name' => $validatedData['name']];

        if ($request->hasFile('logo')) {
            if ($partner->logo_url) {
                Storage::disk('public')->delete($partner->logo_url);
            }
            $path = $request->file('logo')->store('partners', 'public');
            $dataToUpdate['logo_url'] = $path;
        }

        $partner->update($dataToUpdate);
        return response()->json($partner);
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo_url) {
            Storage::disk('public')->delete($partner->logo_url);
        }
        $partner->delete();
        return response()->json(null, 204);
    }
}
