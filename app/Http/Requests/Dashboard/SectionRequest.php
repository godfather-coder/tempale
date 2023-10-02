<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
        $typesAsString = implode(',', config('section.types'));
        $rules = [
            'type' => "required|in:$typesAsString",
            'images' => 'required|array|max:5',
            'images.*' => 'image|mimes:png,jpg,jepg',
            'imagedelete' => 'array|max:5',
            'imagedelete.*' => 'integer|exists:images,id',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.title"] = 'required|string|max:255';
            $rules["$locale.short_description"] = 'required|string|max:255';
            $rules["$locale.slug"] = 'required|string|max:255';
        }

        return $rules;
    }
}
