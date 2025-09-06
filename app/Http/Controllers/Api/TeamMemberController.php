<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        return response()->json(TeamMember::all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048'
        ]);

        $dataToCreate = [
            'name' => $validatedData['name'],
            'title' => $validatedData['title'],
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('team', 'public');
            $dataToCreate['image_url'] = $path;
        }

        $member = TeamMember::create($dataToCreate);
        return response()->json($member, 201);
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048'
        ]);

        $dataToUpdate = [
            'name' => $validatedData['name'],
            'title' => $validatedData['title'],
        ];

        if ($request->hasFile('image')) {
            if ($teamMember->image_url) {
                Storage::disk('public')->delete($teamMember->image_url);
            }
            $path = $request->file('image')->store('team', 'public');
            $dataToUpdate['image_url'] = $path;
        }

        $teamMember->update($dataToUpdate);
        return response()->json($teamMember);
    }

    public function destroy(TeamMember $teamMember)
    {
        if ($teamMember->image_url) {
            Storage::disk('public')->delete($teamMember->image_url);
        }
        $teamMember->delete();
        return response()->json(null, 204);
    }
}
