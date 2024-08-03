<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserSocialLinksRequest extends FormRequest
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
            'telegram' => 'string|max:255|nullable',
            'telegram_hidden' => 'nullable',
            'facebook' => 'string|max:255|nullable',
            'facebook_hidden' => 'nullable',
            'whatsapp' => 'string|max:255|nullable',
            'whatsapp_hidden' => 'nullable',
            'instagram' => 'string|max:255|nullable',
            'instagram_hidden' => 'nullable',
            'twitter' => 'string|max:255|nullable',
            'twitter_hidden' => 'nullable',
        ];
    }
}
