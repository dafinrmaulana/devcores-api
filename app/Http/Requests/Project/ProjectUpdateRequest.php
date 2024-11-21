<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectUpdateRequest extends FormRequest
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
                    ->ignore($this->project->id)
            ],
            "description" => ["required", "string"],
            "project_url" => [
                "required",
                "url",
                "string",
                "max:255",
                Rule::unique('projects', 'project_url')
                    ->where('profile_id', Auth::id())
                    ->ignore($this->project->id)
            ],
            "thumbnail" => ["nullable", "image", "max:2048", "mimes:jpg,jpeg,png"],
            "slug" => [
                "nullable",
                "unique:templates,slug",
                "regex:/^[a-z]+[a-z0-9\-]*$/",
                Rule::unique('projects', 'slug')
                    ->where('profile_id', Auth::id())
                    ->ignore($this->project->id)
            ],
            "profile_id" => ["exists:profiles,id", "integer"]
        ];
    }

    public function data(): array
    {
        $thumbnail = $this->project->thumbnail;
        if ($this->file("thumbnail")) {
            $newThumbnail = $this->file("thumbnail")->store("images/projects", "local");

            if ($this->project->thumbnail) {
                Storage::delete($this->project->thumbnail);
            }

            $thumbnail = $newThumbnail;
        }
        return [
            ...$this->only(["title", "description", "project_url"]),
            "thumbnail" => $thumbnail,
            'slug' => $this->slug,
            "profile_id" => Auth::id()
        ];
    }
}
