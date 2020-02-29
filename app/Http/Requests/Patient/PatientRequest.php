<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            'surname' => 'required|min:3',
            'othernames' => 'required',
            'phone' => 'required|min:10|unique:patients,phone',
            'sex' => 'required',
            'days' => 'required',
            'month' => 'required',
            'years' => 'required',
            // 'occupation' => 'required',
            // 'nationality' => 'required',
            // 'residence' => 'required',
            // 'town' => 'required',
            // 'emergRelation' => 'required',
            // 'emergName' => 'required',
            // 'emergContacts' => 'required',
            // 'email' => 'nullable|email|unique:users,email',
            // 'refference_no' => 'nullable|unique:patients,refference_no',
            
        ];
    }

    public function messages()
    {
        return [
            'surname.required' => 'This field is required.',
            'othernames.required' => 'This field is required.',
            'phone.required' => 'This field is required.',
        ];
    }
}
