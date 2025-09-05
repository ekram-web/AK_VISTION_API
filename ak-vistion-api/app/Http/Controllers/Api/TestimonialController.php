<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        return response()->json(Testimonial::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'quote' => 'required|string',
            'company' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            $data['logo_url'] = $request->file('logo')->store('testimonials', 'public');
        }

        // --- THIS IS THE CRITICAL FIX ---
        // We remove the temporary 'logo' key before saving.
        unset($data['logo']);

        $testimonial = Testimonial::create($data);
        return response()->json($testimonial, 201);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'quote' => 'required|string',
            'company' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            if ($testimonial->logo_url) {
                Storage::disk('public')->delete($testimonial->logo_url);
            }
            $data['logo_url'] = $request->file('logo')->store('testimonials', 'public');
        }

        unset($data['logo']);

        $testimonial->update($data);
        return response()->json($testimonial);
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->logo_url) {
            Storage::disk('public')->delete($testimonial->logo_url);
        }
        $testimonial->delete();
        return response()->json(null, 204);
    }
}
