<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\TaskStatus;
class TaskRequest extends FormRequest
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
        $rules =  [
            'title' => 'required',
            'description' => 'required',
            'status'=>[
                'required',
                 Rule::in(array_keys(TaskStatus::values())),
             ],
            'assigned_to'=>'required|exists:users,uuid'
        ];

        return $rules;

    }
}
