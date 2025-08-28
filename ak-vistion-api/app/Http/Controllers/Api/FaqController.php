<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller {
    public function index() { return response()->json(Faq::all()); }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);
        if ($validator->fails()) { return response()->json($validator->errors(), 422); }
        $faq = Faq::create($request->all());
        return response()->json($faq, 201);
    }

    public function show(Faq $faq) { return response()->json($faq); }
    public function update(Request $request, Faq $faq) { $faq->update($request->all()); return response()->json($faq); }
    public function destroy(Faq $faq) { $faq->delete(); return response()->json(null, 204); }
}
