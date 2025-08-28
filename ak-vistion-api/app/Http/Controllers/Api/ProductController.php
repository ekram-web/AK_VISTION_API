<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request) {
        $query = Product::query();
        if ($request->has('category')) {
            $query->where('main_category', $request->category);
        }
        return response()->json($query->latest()->get());
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'main_category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) { return response()->json($validator->errors(), 422); }

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = $path;
        }
        $product = Product::create($data);
        return response()->json($product, 201);
    }

    public function show(Product $product) { return response()->json($product); }

    public function update(Request $request, Product $product) {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            if ($product->image_url) { Storage::disk('public')->delete($product->image_url); }
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = $path;
        }
        $product->update($data);
        return response()->json($product);
    }

    public function destroy(Product $product) {
        if ($product->image_url) { Storage::disk('public')->delete($product->image_url); }
        $product->delete();
        return response()->json(null, 204);
    }
}
