<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index() { return response()->json(Video::all()); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_url' => 'required|url',
            'date' => 'nullable|date',
            'thumbnail' => 'nullable|image|max:2048' // 2MB Max
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_url'] = $request->file('thumbnail')->store('videos/thumbnails', 'public');
        }

        // Unset the temporary file key before creating the database record
        unset($data['thumbnail']);

        $video = Video::create($data);
        return response()->json($video, 201);
    }

    public function update(Request $request, Video $video)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_url' => 'required|url',
            'date' => 'nullable|date',
            'thumbnail' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail_url) { Storage::disk('public')->delete($video->thumbnail_url); }
            $data['thumbnail_url'] = $request->file('thumbnail')->store('videos/thumbnails', 'public');
        }

        unset($data['thumbnail']);

        $video->update($data);
        return response()->json($video);
    }

    public function destroy(Video $video)
    {
        if ($video->thumbnail_url) { Storage::disk('public')->delete($video->thumbnail_url); }
        $video->delete();
        return response()->json(null, 204);
    }
}
