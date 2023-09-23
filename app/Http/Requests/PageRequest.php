<?php

namespace App\Http\Requests;


class PageRequest extends BaseRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string:min:5',
            'priority' => 'required|integer|min:0|max:100',
            'current' => 'required|integer|in:0,1'
        ];
    }
}