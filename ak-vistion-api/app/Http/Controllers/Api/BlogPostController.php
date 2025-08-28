<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogPostController extends Controller {
    public function index() { return response()->json(BlogPost::latest()->get()); }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($validator->fails()) { return response()->json($validator->errors(), 422); }

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blog', 'public');
            $data['image_url'] = $path;
        }
        $post = BlogPost::create($data);
        return response()->json($post, 201);
    }

    public function show(BlogPost $blogPost) { return response()->json($blogPost); }

    public function update(Request $request, BlogPost $blogPost) {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            if ($blogPost->image_url) { Storage::disk('public')->delete($blogPost->image_url); }
            $path = $request->file('image')->store('blog', 'public');
            $data['image_url'] = $path;
        }
        $blogPost->update($data);
        return response()->json($blogPost);
    }

    public function destroy(BlogPost $blogPost) {
        if ($blogPost->image_url) { Storage::disk('public')->delete($blogPost->image_url); }
        $blogPost->delete();
        return response()->json(null, 204);
    }
}
