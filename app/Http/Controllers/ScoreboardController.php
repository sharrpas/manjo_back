<?php

namespace App\Http\Controllers;

use App\Models\GameRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreboardController extends Controller
{
    public function index()
    {
        $bestRecords = GameRecord::query()
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw('MAX(id) as id, user_id, MAX(score) as score, MAX(created_at) as created_at')
            ->groupBy('user_id')
            ->orderByDesc('score')
            ->limit(10)
            ->with('user:id,username')
            ->get()
            ->map(function ($record) {
                return [
                    'username' => $record->user->username ?? null,
                    'score' => $record->score,
                    'created_at' => $record->created_at,
                ];
            });

        return $this->success($bestRecords);
    }
}
