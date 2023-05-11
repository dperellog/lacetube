<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'teacher_id' => 'required|exists:users,id',
             'name' => 'required|max:255',
             'thumbnail' => 'image',
             'description' => 'required|max:255',
             'year' => 'required|digits:4',
             'parent_id' => 'nullable|exists:courses,id'
        ];
    }
}
