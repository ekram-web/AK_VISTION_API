<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     * Use latest() which defaults to the 'created_at' column for simplicity and reliability.
     */
    public function index()
    {
        return response()->json(BlogPost::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'category' => 'nullable|string',
            'author' => 'nullable|string',
            'date' => 'nullable|string',
            'read_time' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('blog/posts', 'public');
        }

        // We only pass the validated data to the create method.
        $post = BlogPost::create($data);
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost)
    {
        return response()->json($blogPost);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'category' => 'nullable|string',
            'author' => 'nullable|string',
            'date' => 'nullable|string',
            'read_time' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($blogPost->image_url) {
                Storage::disk('public')->delete($blogPost->image_url);
            }
            // Store the new image and update the path
            $data['image_url'] = $request->file('image')->store('blog/posts', 'public');
        }

        $blogPost->update($data);
        return response()->json($blogPost);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->image_url) {
            Storage::disk('public')->delete($blogPost->image_url);
        }
        $blogPost->delete();
        return response()->json(null, 204);
    }
}
