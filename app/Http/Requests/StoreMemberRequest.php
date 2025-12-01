<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMemberRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $maxYear = (int) date('Y') + 1;

        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'student_number' => ['required', 'string', 'max:50', 'unique:users,student_number'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'batch_year' => ['required', 'integer', 'between:2000,' . $maxYear],
            'phone' => ['nullable', 'string', 'max:30'],
            'is_active' => ['sometimes', 'boolean'],
            'gender' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['nullable', 'date', 'before:tomorrow'],
            'address' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'role' => ['nullable', 'string', Rule::in(['non_member', 'member', 'bph', 'demisioner', 'alumni'])],
        ];
    }
}
