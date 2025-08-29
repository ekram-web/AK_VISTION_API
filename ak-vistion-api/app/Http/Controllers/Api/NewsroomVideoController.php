<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\NewsroomVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NewsroomVideoController extends Controller {
    public function index() { return response()->json(NewsroomVideo::all()); }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), ['video' => 'required|file|mimes:mp4,mov,avi|max:20480']); // 20MB Max
        if ($validator->fails()) { return response()->json($validator->errors(), 422); }

        $path = $request->file('video')->store('homepage/newsroom', 'public');
        $video = NewsroomVideo::create(['video_url' => $path]);
        return response()->json($video, 201);
    }

    public function destroy(NewsroomVideo $newsroomVideo) {
        if ($newsroomVideo->video_url) { Storage::disk('public')->delete($newsroomVideo->video_url); }
        $newsroomVideo->delete();
        return response()->json(null, 204);
    }
}
