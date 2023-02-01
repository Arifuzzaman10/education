<?php

namespace App\Http\Requests\Admin\Examination;

use Illuminate\Foundation\Http\FormRequest;

class SmExamFormatSettingsRequest extends FormRequest
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
        $maxFileSize=generalSetting()->file_size*1024;
        return [
            'exam_type' => "required",
            'title' => "required",
            'publish_date' => "required",
            'start_date' => "required|before:end_date",
            'end_date' => "required|before:publish_date",
            'file' => "sometimes|nullable|mimes:jpg,jpeg,png,svg|max:".$maxFileSize,
        ];
    }
}
