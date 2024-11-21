<?php

namespace App\Http\Requests\Skill;

use App\Http\Requests\ValidationHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SkillStoreRequest extends ValidationHandler
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
            "profile_id" => ["nullable", "exists:profiles,id", "integer"],
            "name" => [
                "required",
                "string",
                "max:255",
                Rule::unique('skills', 'name')
                    ->where('profile_id', Auth::id())
            ],
            "slug" => [
                "nullable",
                "unique:templates,slug",
                "regex:/^[a-z]+[a-z0-9\-]*$/",
                Rule::unique('skills', 'slug')
                    ->where('profile_id', Auth::id())
            ],
            "description" => ["nullable", "string"],
            "proficiency" => ["required", "integer", "min:10", "max:100"]
        ];
    }

    public function data(): array
    {
        return [
            ...$this->only(['name', 'description', 'proficiency']),
            'slug' => $this->slug ?? preg_replace('/[^a-z0-9]+/', '-', strtolower(trim($this->name))),
            'profile_id' => Auth::id()
        ];
    }
}
