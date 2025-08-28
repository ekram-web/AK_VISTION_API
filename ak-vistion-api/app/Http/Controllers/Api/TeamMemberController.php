<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller {
    public function index() { return response()->json(TeamMember::all()); }

    public function store(Request $request) {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('team', 'public');
            $data['image_url'] = $path;
        }
        $member = TeamMember::create($data);
        return response()->json($member, 201);
    }

    public function update(Request $request, TeamMember $teamMember) {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            if ($teamMember->image_url) { Storage::disk('public')->delete($teamMember->image_url); }
            $path = $request->file('image')->store('team', 'public');
            $data['image_url'] = $path;
        }
        $teamMember->update($data);
        return response()->json($teamMember);
    }

    public function destroy(TeamMember $teamMember) {
        if ($teamMember->image_url) { Storage::disk('public')->delete($teamMember->image_url); }
        $teamMember->delete();
        return response()->json(null, 204);
    }
}
