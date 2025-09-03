<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\NewsroomVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsroomVideoController extends Controller {
    public function index() { return response()->json(NewsroomVideo::all()); }
    public function store(Request $request) {
        $data = $request->validate(['video' => 'required|file|mimes:mp4,mov,avi|max:20480']); // 20MB Max
        if ($request->hasFile('video')) {
            $data['video_url'] = $request->file('video')->store('homepage/newsroom', 'public');
        }
        $video = NewsroomVideo::create($data);
        return response()->json($video, 201);
    }
    public function destroy(NewsroomVideo $newsroomVideo) {
        if ($newsroomVideo->video_url) { Storage::disk('public')->delete($newsroomVideo->video_url); }
        $newsroomVideo->delete();
        return response()->json(null, 204);
    }
}
