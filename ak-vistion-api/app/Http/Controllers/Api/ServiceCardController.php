<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ServiceCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceCardController extends Controller {
    public function index() { return response()->json(ServiceCard::all()); }
    public function store(Request $request) {
        $data = $request->validate(['name' => 'required', 'image' => 'nullable|image']);
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('services/cards', 'public');
        }
        $card = ServiceCard::create($data);
        return response()->json($card, 201);
    }
    public function update(Request $request, ServiceCard $serviceCard) {
        $data = $request->validate(['name' => 'required', 'image' => 'nullable|image']);
        if ($request->hasFile('image')) {
            if ($serviceCard->image_url) Storage::disk('public')->delete($serviceCard->image_url);
            $data['image_url'] = $request->file('image')->store('services/cards', 'public');
        }
        $serviceCard->update($data);
        return response()->json($serviceCard);
    }
    public function destroy(ServiceCard $serviceCard) {
        if ($serviceCard->image_url) Storage::disk('public')->delete($serviceCard->image_url);
        $serviceCard->delete();
        return response()->json(null, 204);
    }
}
