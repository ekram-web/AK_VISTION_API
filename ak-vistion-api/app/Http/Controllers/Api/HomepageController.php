<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomepageData;

class HomepageController extends Controller
{
    // Get all simple content for the homepage
    public function index()
    {
        // Pluck creates an associative array: ['section' => 'content', ...]
        $data = HomepageData::pluck('content', 'section')->map(function ($content) {
            return json_decode($content, true); // Decode each JSON string
        });
        return response()->json($data);
    }

    // Update all simple content sections at once
    public function update(Request $request)
    {
        $sections = $request->all();
        foreach ($sections as $section => $content) {
            HomepageData::updateOrCreate(
                ['section' => $section],
                ['content' => json_encode($content)]
            );
        }
        return response()->json(['message' => 'Homepage content updated successfully!']);
    }
}
