<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
        $rules = [
            'images' => 'required|array|max:5',
            'images.*' => 'image|mimes:png,jpg,jepg',
            'imagedelete' => 'array|max:5',
            'imagedelete.*' => 'integer|exists:images,id', //snakeCase
            'type' => 'required|string|max:255',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.title"] = 'required|string|max:255';
            $rules["$locale.text"] = 'required|string';
            $rules["$locale.link"] = 'required|string|max:255';
        }

        return $rules;
    }
}
