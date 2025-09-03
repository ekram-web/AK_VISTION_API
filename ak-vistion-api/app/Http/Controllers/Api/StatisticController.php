<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller {
    public function index() { return response()->json(Statistic::all()); }
    public function store(Request $request) {
        $data = $request->validate(['label' => 'required', 'value' => 'required']);
        $stat = Statistic::create($data);
        return response()->json($stat, 201);
    }
    public function update(Request $request, Statistic $statistic) {
        $data = $request->validate(['label' => 'required', 'value' => 'required']);
        $statistic->update($data);
        return response()->json($statistic);
    }
    public function destroy(Statistic $statistic) { $statistic->delete(); return response()->json(null, 204); }
}
