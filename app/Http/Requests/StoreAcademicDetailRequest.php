<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicDetailRequest extends FormRequest
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

        // [$this->input('degree_type')]);
        return [
            'type' => ['required', Rule::in(array_keys(config('constants.academic_details.degree_types')))],
            'title' => ['required', Rule::in(config('constants.academic_details.degree_types')[$this->input('type')])],
            'exam_type' => 'required',
            'reg_no' => 'required',
            'passing_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'organization_id' => 'required|exists:organizations,id',
            'total_marks' => 'required|numeric',
            'obtained_marks' => 'required|numeric|lte:total_marks',
        ];
    }
}