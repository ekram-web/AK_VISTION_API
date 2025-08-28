<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use Illuminate\Http\Request;

class LegalPageController extends Controller {
public function show($page_key) {
// Find or create to ensure it always exists for the admin panel
$page = LegalPage::firstOrCreate(
['page_key' => $page_key],
['content' => "<h1>".ucfirst($page_key)." Page</h1><p>Edit this content.</p>", 'last_updated' => now()]
);
return response()->json($page);
}

public function update(Request $request, $page_key) {
$page = LegalPage::updateOrCreate(
['page_key' => $page_key],
['content' => $request->input('content'), 'last_updated' => now()]
);
return response()->json($page);
}
}
