<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        return $user && ($user->isTeacher() || $user->isAdministrator());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:courses,code',
            'description' => 'required|string',
            'grade_level' => 'required|in:7th,8th,9th',
            'subject' => 'required|string|max:100',
            'teacher_id' => 'required|exists:users,id',
            'cover_image' => 'nullable|string|url',
            'status' => 'required|in:draft,published,archived',
            'duration_weeks' => 'required|integer|min:1|max:52',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Course title is required.',
            'code.required' => 'Course code is required.',
            'code.unique' => 'This course code is already taken.',
            'description.required' => 'Course description is required.',
            'grade_level.required' => 'Grade level is required.',
            'grade_level.in' => 'Grade level must be 7th, 8th, or 9th.',
            'teacher_id.required' => 'Teacher assignment is required.',
            'teacher_id.exists' => 'Selected teacher does not exist.',
            'duration_weeks.min' => 'Course duration must be at least 1 week.',
            'duration_weeks.max' => 'Course duration cannot exceed 52 weeks.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // If user is a teacher, automatically set teacher_id to current user
        if (Auth::user() && Auth::user()->isTeacher()) {
            $this->merge([
                'teacher_id' => Auth::id(),
            ]);
        }
    }
}