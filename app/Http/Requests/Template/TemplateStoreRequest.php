<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\ValidationHandler;

class TemplateStoreRequest extends ValidationHandler
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
            "name" => ["required", "max:255", "unique:templates,name"],
            "slug" => ["nullable", "string", "unique:templates,slug", "regex:/^[a-z]+[a-z0-9\-]*$/"],
            "description" => ["nullable"],
            "thumbnail" => ["required", "image", "mimes:jpg,jpeg,png", "max:2048"],
        ];
    }

    public function data(): array
    {
        return [
            ...$this->only(["name", "description"]),
            'slug' => $this->slug || preg_replace('/[^a-z0-9]/', '-', strtolower($this->name)),
            'thumbnail' => $this->file('thumbnail')->store('images/templates', 'local'),
        ];
    }
}
