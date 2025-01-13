<?php

namespace App\Http\Resources;

use App\Models\Gender;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PlayerResource extends JsonResource
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
            'skill_level' => $this->skill_level,
            'gender' => $this->whenLoaded('gender', fn(Gender $gender) => $gender->name),
            'skills' => $this->whenLoaded('skills', fn(Collection $skills) => $skills->map(
                fn(Skill $skill) => [
                    'name' => $skill->name,
                    'score' => "{$skill->player_score->score}{$skill->unit->symbol}"
                ],
            )),
            'tournaments' => TournamentResource::collection($this->whenLoaded('tournaments')),
            'created_at' => Carbon::createFromTimeString(
                $this->created_at
            )->format('d-m-Y H:i:s'),
        ];
    }
}
