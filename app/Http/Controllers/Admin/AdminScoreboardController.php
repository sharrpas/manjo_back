<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameRecordCollection;
use App\Models\GameRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminScoreboardController extends Controller
{
    public function index(Request $request)
    {
        $bestRecords = GameRecord::query()
            ->whereBetween('created_at',[$request->from, $request->to])
            ->selectRaw('MAX(id) as id, user_id, MAX(score) as score, MAX(created_at) as created_at')
            ->groupBy('user_id')
            ->orderByDesc('score')
            ->limit(10)
            ->with('user:id,username');

        return $this->success((new GameRecordCollection($bestRecords->paginate(20))));
    }
}
