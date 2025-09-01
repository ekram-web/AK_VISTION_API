<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ServicePageData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicesPageController extends Controller {
    // Fetches the simple, non-CRUD content
    public function index() {
        $data = ServicePageData::pluck('content', 'section')->map(fn ($c) => json_decode($c, true));
        return response()->json($data);
    }

    // Handles saving the simple content and header image upload
    public function update(Request $request) {
        $dataToSave = $request->except('headerImage');
        foreach ($dataToSave as $sectionKey => $content) {
            ServicePageData::updateOrCreate(['section' => $sectionKey], ['content' => json_encode($content)]);
        }

        if ($request->hasFile('headerImage')) {
            $headerData = json_decode(ServicePageData::where('section', 'header')->value('content'), true) ?? [];
            if(isset($headerData['imageUrl'])) Storage::disk('public')->delete($headerData['imageUrl']);
            $headerData['imageUrl'] = $request->file('headerImage')->store('services', 'public');
            ServicePageData::updateOrCreate(['section' => 'header'], ['content' => json_encode($headerData)]);
        }

        return response()->json(['message' => 'Services page content updated!']);
    }
}
