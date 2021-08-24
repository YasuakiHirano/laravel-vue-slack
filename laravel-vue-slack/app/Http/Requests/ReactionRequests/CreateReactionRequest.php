<?php

namespace App\Http\Requests\ReactionRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReactionRequest extends FormRequest
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
            'message_id' => 'required',
            'reaction_user_id' => 'required',
            'icon_code' => 'required',
            'icon' => 'required',
        ];
    }
}
