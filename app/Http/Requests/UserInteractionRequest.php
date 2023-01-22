<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserInteractionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'other_user_id' => $this->route('otherUser')->id,
        ]);
    }

    /**
     * Validation rules.
     *
     */
    public function rules(): array
    {
        return [
            'logged_user_id' => ['required', 'integer', 'exists:App\Models\User,id'],
            'other_user_id' => ['required', 'integer', Rule::exists('users', 'id')->where(function ($query) {
                return $query->whereNot('id', $this->logged_user_id);
            })],
        ];
    }

}
