<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserInfoRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'string|max:255|nullable',
            'home_tel' => 'string|max:20|nullable',
            'work_tel' => 'string|max:20|nullable',
            'website' => 'string|url|nullable',
            'company' => 'string|nullable',
            'job_title' => 'string|nullable'
        ];
    }
}
