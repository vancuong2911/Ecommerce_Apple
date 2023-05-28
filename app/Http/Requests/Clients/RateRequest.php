<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'star_value' => 'required',
            'comments' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'star_value.required' => 'Vui lòng chọn sao đánh giá.',
            'comments.email' => 'Hãy để lại bình luận của bạn.',
        ];
    }
}
