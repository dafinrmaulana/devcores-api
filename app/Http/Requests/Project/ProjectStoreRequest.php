<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\ValidationHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectStoreRequest extends ValidationHandler
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
            "title" => [
                "required",
                "string",
                "max:255",
                Rule::unique('projects', 'title')
                    ->where('profile_id', Auth::id())
            ],
            "description" => ["required", "string"],
            "project_url" => [
                "required",
                "url",
                "string",
                "max:255",
                Rule::unique('projects', 'project_url')
                    ->where('profile_id', Auth::id())
            ],
            "thumbnail" => ["nullable", "image", "max:2048", "mimes:jpg,jpeg,png"],
            "slug" => [
                "nullable",
                "unique:templates,slug",
                "regex:/^[a-z]+[a-z0-9\-]*$/",
                Rule::unique('projects', 'slug')
                    ->where('profile_id', Auth::id())
            ],
            "profile_id" => ["exists:profiles,id", "integer"]
        ];
    }

    public function data(): array
    {
        return [
            ...$this->only(["title", "description", "project_url"]),
            "thumbnail" => $this->file("thumbnail") ? $this->file("thumbnail")->store("images/projects", "local") : $this->thumbnail,
            'slug' => $this->slug ?? preg_replace('/[^a-z0-9]+/', '-', strtolower(trim($this->title))),
            "profile_id" => Auth::id()
        ];
    }
}
