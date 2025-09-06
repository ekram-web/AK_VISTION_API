<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Import all necessary models
use App\Models\HomepageData;
use App\Models\AboutPageData;
use App\Models\ServicesPageData;
use App\Models\Faq;
use App\Models\LegalPage;

class PageContentController extends Controller
{
// A single endpoint to get all page content for the public site
public function getPublicSiteData() {
// In a real app, you would structure this more elegantly
return response()->json([
'homepage' => HomepageData::all(),
'about' => AboutPageData::all(),
'services' => ServicesPageData::all(),
]);
}

// You would have separate methods for updating each section, e.g.:
public function updateHomepage(Request $request) {
$section = $request->input('section');
$content = $request->input('content');

HomepageData::updateOrCreate(
['section' => $section],
['content' => $content]
);

return response()->json(['message' => 'Homepage content updated!']);
}
