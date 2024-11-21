<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\ValidationHandler;
use Illuminate\Support\Facades\Storage;

class TemplateUpdateRequest extends ValidationHandler
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
            "name" => ["required", "max:255", "unique:templates,name,{$this->template->id}"],
            "slug" => ["required", "unique:templates,slug,{$this->template->id}", "regex:/^[a-z]+[a-z0-9\-]*$/"],
            "description" => ["nullable"],
            "thumbnail" => ["nullable", "image", "mimes:jpg,jpeg,png", "max:2048"],
        ];
    }

    public function data(): array
    {
        $thumbnail = $this->template->thumbnail;
        if ($this->file("thumbnail")) {
            $newThumbnail = $this->file("thumbnail")->store("images/templates", "local");

            if ($this->template->thumbnail) {
                Storage::delete($this->template->thumbnail);
            }

            $thumbnail = $newThumbnail;
        }
        return [
            ...$this->only(["name", "description", "slug"]),
            'thumbnail' => $thumbnail
        ];
    }
}
