<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomEmailRequest extends FormRequest
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
            'data' => 'required|array',
            'data.*' => 'array',
            'data.*.email' => 'required|email',
            'data.*.body' => 'required|string',
            'data.*.subject' => 'required|string',
            'data.*.attachments' => 'nullable|array',
            'data.*.attachments.*.name' => 'required|string|min:3|max:191',
            'data.*.attachments.*.content' => 'required|string',
        ];
    }

    public function validated() {
        return collect($this->validator->validated()['data']);
    }

}
