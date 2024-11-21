<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\ValidationHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileUpdateRequest extends ValidationHandler
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
        $userId = Auth::id();
        return [
            // users table
            "name" => ["required", "string"],
            "username" => ["required", "string", "unique:users,username,{$userId}", "regex:/^[a-zA-Z0-9]+$/"],

            // profiles table
            "about" => ["nullable"],
            "links" => ["nullable", "json"],

            // relations
            "user_id" => ["exists:users,id"],
            "template_id" => ["required", "exists:templates,id"],
        ];
    }

    public function messages(): array
    {
        return [
            "links.json" => "The links field must be a valid JSON string.",
            "template_id.required" => "The template field is required.",
            "template_id.exists" => "The selected template does not exist.",
            "user_id.exists" => "The selected user does not exist.",
            "user_id.required" => "The user field is required.",
            "username.regex" => "The username may only contain letters, numbers, dashes, and underscores.",
        ];
    }

    public function data($data): array
    {
        $thumbnail = $data->avatar;

        if ($this->file('avatar') && $data->avatar !== null) {
            $thumbnail = $this->file('avatar')->store('images/profiles', 'local');
            Storage::delete($data->avatar);
        }

        $thumbnail = $this->file('avatar')->store('images/profiles', 'local');

        return [
            ...$this->only(['about', 'links', 'template_id', 'name', 'username']),
            'user_id' => Auth::id(),
            'avatar' => $thumbnail,
        ];
    }
}
