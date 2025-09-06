<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('products', 'public');
        }
        $product = Product::create($data);
        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product) {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            if ($product->image_url) { Storage::disk('public')->delete($product->image_url); }
            $data['image_url'] = $request->file('image')->store('products', 'public');
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
