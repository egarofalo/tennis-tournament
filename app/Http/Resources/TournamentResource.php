<?php

namespace App\Http\Resources;

use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TournamentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->whenLoaded('gender', fn(Gender $gender) => $gender->name),
            'winner' => new PlayerResource($this->whenLoaded('winner')),
            'players' => PlayerResource::collection($this->whenLoaded('players')),
            'created_at' => Carbon::createFromTimeString(
                $this->created_at
            )->format('d-m-Y H:i:s'),
        ];
    }
}
