<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\AboutPageData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutPageController extends Controller {
    // This controller ONLY handles the simple key-value/JSON sections.
    public function index() {
        $data = AboutPageData::pluck('content', 'section')->map(fn ($c) => json_decode($c, true));
        return response()->json($data);
    }

    public function update(Request $request) {
        // Handle simple text fields
        foreach ($request->only(['inspiring', 'process']) as $sectionKey => $content) {
            AboutPageData::updateOrCreate(['section' => $sectionKey], ['content' => json_encode($content)]);
        }

        // Handle file uploads for specific sections
        if ($request->hasFile('image1') || $request->hasFile('image2')) {
            $inspiringData = json_decode(AboutPageData::where('section', 'inspiring')->value('content'), true) ?? [];
            if ($request->hasFile('image1')) {
                if(isset($inspiringData['image1_url'])) Storage::disk('public')->delete($inspiringData['image1_url']);
                $inspiringData['image1_url'] = $request->file('image1')->store('about', 'public');
            }
             if ($request->hasFile('image2')) {
                if(isset($inspiringData['image2_url'])) Storage::disk('public')->delete($inspiringData['image2_url']);
                $inspiringData['image2_url'] = $request->file('image2')->store('about', 'public');
            }
            AboutPageData::updateOrCreate(['section' => 'inspiring'], ['content' => json_encode($inspiringData)]);
        }

        if ($request->hasFile('promo_video') || $request->hasFile('poster_image')) {
            $promoData = json_decode(AboutPageData::where('section', 'promoVideo')->value('content'), true) ?? [];
             if ($request->hasFile('promo_video')) {
                if(isset($promoData['video_url'])) Storage::disk('public')->delete($promoData['video_url']);
                $promoData['video_url'] = $request->file('promo_video')->store('about', 'public');
            }
            if ($request->hasFile('poster_image')) {
                if(isset($promoData['poster_url'])) Storage::disk('public')->delete($promoData['poster_url']);
                $promoData['poster_url'] = $request->file('poster_image')->store('about', 'public');
            }
            AboutPageData::updateOrCreate(['section' => 'promoVideo'], ['content' => json_encode($promoData)]);
        }

        return response()->json(['message' => 'About page content updated!']);
    }
}
