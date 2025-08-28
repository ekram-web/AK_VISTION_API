<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\SupportFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SupportFileController extends Controller {
public function index(Request $request) {
$query = SupportFile::query();
if ($request->has('type')) {
$query->where('type', $request->type);
}
return response()->json($query->latest()->get());
}

public function store(Request $request) {
$validator = Validator::make($request->all(), [
'name' => 'required|string|max:255',
'type' => 'required|in:Firmware,SDK,Software',
'file' => 'required|file|max:51200' // 50MB max upload
]);
if ($validator->fails()) { return response()->json($validator->errors(), 422); }

$data = $request->except('file');
$path = $request->file('file')->store('support-files/' . strtolower($request->type), 'public');
$data['file_url'] = $path;

$file = SupportFile::create($data);
return response()->json($file, 201);
}

public function show(SupportFile $supportFile) { return response()->json($supportFile); }

public function update(Request $request, SupportFile $supportFile) {
$data = $request->except('file');
if ($request->hasFile('file')) {
if ($supportFile->file_url) { Storage::disk('public')->delete($supportFile->file_url); }
$path = $request->file('file')->store('support-files/' . strtolower($supportFile->type), 'public');
$data['file_url'] = $path;
}
$supportFile->update($data);
return response()->json($supportFile);
}

public function destroy(SupportFile $supportFile) {
if ($supportFile->file_url) { Storage::disk('public')->delete($supportFile->file_url); }
$supportFile->delete();
return response()->json(null, 204);
}
}
