<?php

namespace App\Http\Requests\Timesheet;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="TimesheetCreateRequest",
 *     type="object",
 *     @OA\Property(property="date", type="string"),
 *     @OA\Property(property="hours", type="number"),
 *     @OA\Property(property="task_name", type="string"),
 *     @OA\Property(property="project_id", type="integer"),
 *     @OA\Property(property="user_id", type="integer")
 * )
 */
class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'hours' => ['required', 'numeric', 'min:0'],
            'task_name' => ['required', 'string', 'max:255'],
            'project_id' => ['required', 'exists:projects,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
