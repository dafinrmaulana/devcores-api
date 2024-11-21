<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ValidationHandler;

class RegisterStoreRequest extends ValidationHandler
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
            "name" => ["required", "string"],
            "username" => ["nullable", "string", "unique:users,username", "regex:/^[a-zA-Z0-9]+$/"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "string", "min:8", "confirmed"],
        ];
    }

    public function data(): array
    {
        $username = $this->username;
        if ($this->username === null || $this->username === "") {
            $username = preg_replace('/[^a-zA-Z0-9]/', '', $this->name);
        }
        return [
            ...$this->only(["name", "email", "password"]),
            "username" => $username
        ];
    }
}
