<?php

namespace App\Http\Requests;


class StoreClubRequest extends BaseRequest
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
            'clubs.*.club_id' => 'required|integer|exists:clubs,id',
            'clubs.*.points' => 'required|integer|min:0',
            'clubs.*.games_count' => 'required|integer|min:0'
            // 'club_id' => 'required|integer|exists:clubs,id',
            // 'points' => 'required|integer|min:0',
            // 'games_count' => 'required|integer|min:0'
        ];
    }
}
