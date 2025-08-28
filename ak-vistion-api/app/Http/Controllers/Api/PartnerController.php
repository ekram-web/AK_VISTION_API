<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Partner::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except('logo');
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('partners', 'public');
            $data['logo_url'] = $path;
        }

        $partner = Partner::create($data);
        return response()->json($partner, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        return response()->json($partner);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $data = $request->except('logo');
        if ($request->hasFile('logo')) {
            if ($partner->logo_url) {
                Storage::disk('public')->delete($partner->logo_url);
            }
            $path = $request->file('logo')->store('partners', 'public');
            $data['logo_url'] = $path;
        }

        $partner->update($data);
        return response()->json($partner);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        if ($partner->logo_url) {
            Storage::disk('public')->delete($partner->logo_url);
        }
        $partner->delete();
        return response()->json(null, 204);
    }
}
