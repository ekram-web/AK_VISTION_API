<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\HomepageData;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    // This now ONLY handles the 'hero' section data.
    public function index()
    {
        $heroData = HomepageData::where('section', 'hero')->first();
        // Provide a default if no data exists in the database yet
        if (!$heroData) {
            return response()->json(['hero' => ['title' => 'Default Title', 'subtitle' => 'Default Subtitle']]);
        }
        return response()->json(['hero' => json_decode($heroData->content, true)]);
    }

    public function update(Request $request)
    {
        $heroContent = $request->input('hero');
        if ($heroContent) {
            HomepageData::updateOrCreate(
                ['section' => 'hero'],
                ['content' => json_encode($heroContent)]
            );
        }
        return response()->json(['message' => 'Homepage content updated successfully!']);
    }
}
