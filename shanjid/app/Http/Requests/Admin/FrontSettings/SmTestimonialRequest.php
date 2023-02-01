<?php

namespace App\Http\Requests\Admin\FrontSettings;

use Illuminate\Foundation\Http\FormRequest;

class SmTestimonialRequest extends FormRequest
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
        $maxFileSize =generalSetting()->file_size*1024;
        return [
            'name' => 'required|max:250',
            'designation' => 'required|max:250',
            'institution_name' => 'required|max:250',
            'image' => "required|mimes:jpg,jpeg,png|max:".$maxFileSize,
            'description' => 'required',
        ];
    }
}
