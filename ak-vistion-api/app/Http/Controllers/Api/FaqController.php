<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index()
    {
        return response()->json(Faq::latest()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);
        $faq = Faq::create($data);
        return response()->json($faq, 201);
    }

    public function show(Faq $faq)
    {
        return response()->json($faq);
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);
        $faq->update($data);
        return response()->json($faq);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return response()->json(null, 204);
    }
}
