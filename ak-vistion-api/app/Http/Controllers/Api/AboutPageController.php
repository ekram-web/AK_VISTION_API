<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\AboutPageData;
use Illuminate\Http\Request;

class AboutPageController extends Controller {
    public function index() {
        $data = AboutPageData::pluck('content', 'section')->map(fn ($c) => json_decode($c, true));
        return response()->json($data);
    }

    public function update(Request $request) {
        foreach ($request->all() as $section => $content) {
            AboutPageData::updateOrCreate(['section' => $section], ['content' => json_encode($content)]);
        }
        return response()->json(['message' => 'About page content updated!']);
    }
}
