<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\HomepageData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageController extends Controller
{
    public function index()
    {
        $heroData = HomepageData::where('section', 'hero')->first();
        if (!$heroData) {
            return response()->json(['hero' => ['title' => '', 'subtitle' => '', 'video_url' => '']]);
        }
        return response()->json(['hero' => json_decode($heroData->content, true)]);
    }

    public function update(Request $request)
    {
        $currentData = HomepageData::where('section', 'hero')->first();
        $content = $currentData ? json_decode($currentData->content, true) : [];

        $dataToSave = [
            'title' => $request->input('title', $content['title'] ?? ''),
            'subtitle' => $request->input('subtitle', $content['subtitle'] ?? ''),
        ];

        if ($request->hasFile('video')) {
            if (isset($content['video_url'])) {
                 Storage::disk('public')->delete($content['video_url']);
            }
            $path = $request->file('video')->store('homepage/hero', 'public');
            $dataToSave['video_url'] = $path;
        } else {
            $dataToSave['video_url'] = $content['video_url'] ?? '';
        }

        HomepageData::updateOrCreate(
            ['section' => 'hero'],
            ['content' => json_encode($dataToSave)]
        );
        return response()->json(['message' => 'Hero section updated successfully!']);
    }
}
