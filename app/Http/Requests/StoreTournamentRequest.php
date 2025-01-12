<?php

namespace App\Http\Requests;

use App\Models\Gender;
use App\Rules\PowerOfTwoArray;
use App\Rules\SkillMatchesGender;
use App\Rules\UniqueSkills;
use Illuminate\Foundation\Http\FormRequest;

class StoreTournamentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gender_id' => 'required|integer|min:1|exists:genders,id',
            'name' => 'required|string|max:100',
            'players' => [
                'bail',
                'required',
                'array',
                new PowerOfTwoArray,
            ],
            'players.*.name' => 'required|string|max:100',
            'players.*.skill_level' => 'required|integer|min:1|max:100',
            'players.*.male_skills' => 'exclude_unless:gender_id,' . Gender::MALE . '|required|array:strength,speed',
            'players.*.male_skills.strength' => 'required|integer|min:1|max:100',
            'players.*.male_skills.speed' => 'required|integer|min:1|max:100',
            'players.*.female_skills' => 'exclude_unless:gender_id,' . Gender::FEMALE . '|required|array:reaction_time',
            'players.*.female_skills.reaction_time' => 'required|integer|min:1|max:100',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'players.*.male_skills.array' => 'The :attribute field must be an array with strength and speed keys only',
            'players.*.female_skills.array' => 'The :attribute field must be an array with reaction_time key only',
        ];
    }
}
