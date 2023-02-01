<?php

namespace App\Http\Requests\Admin\AdminSection;

use Illuminate\Foundation\Http\FormRequest;

class SmStudentCertificateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $maxFileSize =generalSetting()->file_size*1024;
        return [
            'name' => "required|max:50",
            'file' => "mimes:pdf,txt,doc,docx,jpg,jpeg,png|dimensions:width=1100,height=850|max:".$maxFileSize
        ];

    }
}
