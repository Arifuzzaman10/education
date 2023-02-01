<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class SmSupplierRequest extends FormRequest
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
            'company_name' => "required|max:200",
            'company_address' => "required",
            'contact_person_name' => "required|max:200",
            'contact_person_email' => "sometimes|nullable|email",
            'contact_person_mobile' => "sometimes|nullable",
            'description' => "sometimes|nullable"
        ];
    }
}
