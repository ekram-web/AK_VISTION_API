<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FooterContactDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FooterContactDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(FooterContactDetail::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|in:Address,Phone,Email,Hours',
            'value' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        $detail = FooterContactDetail::create($data);
        return response()->json($detail, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FooterContactDetail $footerContactDetail)
    {
        return response()->json($footerContactDetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FooterContactDetail $footerContactDetail)
    {
        $data = $request->validate([
            'type' => 'required|string|in:Address,Phone,Email,Hours',
            'value' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        $footerContactDetail->update($data);
        return response()->json($footerContactDetail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FooterContactDetail $footerContactDetail)
    {
        $footerContactDetail->delete();
        return response()->json(null, 204);
    }
}
