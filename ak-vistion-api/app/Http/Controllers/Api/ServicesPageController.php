<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ServicesPageData;
use Illuminate\Http\Request;

class ServicesPageController extends Controller {
public function index() {
$data = ServicesPageData::pluck('content', 'section')->map(fn ($c) => json_decode($c, true));
return response()->json($data);
}

public function update(Request $request) {
foreach ($request->all() as $section => $content) {
ServicesPageData::updateOrCreate(['section' => $section], ['content' => json_encode($content)]);
}
return response()->json(['message' => 'Services page content updated!']);
}
}
