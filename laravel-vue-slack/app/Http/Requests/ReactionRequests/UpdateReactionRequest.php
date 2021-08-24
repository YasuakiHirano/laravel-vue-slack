<?php

namespace App\Http\Requests\ReactionRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reaction_id' => 'required',
            'user_id' => 'required',
        ];
    }
}
