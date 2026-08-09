<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'telephone' => ['nullable', 'string', 'max:30'],
            'date_naissance' => ['nullable', 'date'],
            'lieu_naissance' => ['nullable', 'string', 'max:255'],
            'nationalite' => ['nullable', 'string', 'max:255'],
            'cin' => ['nullable', 'string', 'max:50'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'situation_familiale' => ['nullable', 'string', 'max:50'],
        ];
    }
}