<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'username' => $this->username,
            'phone' => $this->phone ?? null,
            'phone_verified_at' => $this->phone_verified_at ?? null,
            'game_records' => (new GameRecordCollection($this->gameRecords()->select('id', 'score', 'created_at')->paginate(10))),
        ];
    }
}
