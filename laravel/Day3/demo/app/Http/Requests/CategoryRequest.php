<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category');
        return [
            "name" => "required|min:3|max:20|string|unique:categories,name," . $categoryId,
            "descripyion" => "required|min:12|max:100|string"
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "name is required",
            "name.min" => "name must be at least 3 characters",
            "name.unique" => "name is already exist",
            "descripyion.required" => "description is required",
            "descripyion.min" => "description must be at least 12 characters",
        ];
    }
}