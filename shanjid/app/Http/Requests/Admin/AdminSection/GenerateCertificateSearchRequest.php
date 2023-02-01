<?php

namespace App\Http\Requests\Admin\AdminSection;

use Illuminate\Foundation\Http\FormRequest;

class GenerateCertificateSearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'class' => 'required',
            'section'=>'nullable',
            'certificate' => 'required'
        ];
    }
}
