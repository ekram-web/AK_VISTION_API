<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\HomepageData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageController extends Controller {
    // This ONLY manages the Hero section text and video.
    public function index() {
        $heroData = HomepageData::where('section', 'hero')->first();
        if (!$heroData) { return response()->json(['hero' => ['title' => '', 'subtitle' => '', 'video_url' => '']]); }
        return response()->json(['hero' => json_decode($heroData->content, true)]);
    }
    public function update(Request $request) {
        $data = $request->validate(['title' => 'required', 'subtitle' => 'required', 'video' => 'nullable|file|mimes:mp4,mov']);
        $currentData = HomepageData::where('section', 'hero')->first();
        $content = $currentData ? json_decode($currentData->content, true) : [];

        $content['title'] = $data['title'];
        $content['subtitle'] = $data['subtitle'];

        if ($request->hasFile('video')) {
            if (isset($content['video_url'])) { Storage::disk('public')->delete($content['video_url']); }
            $content['video_url'] = $request->file('video')->store('homepage/hero', 'public');
        }

        HomepageData::updateOrCreate(['section' => 'hero'], ['content' => json_encode($content)]);
        return response()->json(['message' => 'Hero section updated successfully!']);
    }
}
