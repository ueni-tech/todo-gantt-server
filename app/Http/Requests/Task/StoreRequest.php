<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  // public function authorize(): bool
  // {
  //     return false;
  // }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'project_id' => 'required|integer|exists:projects,id',
      'name' => 'required|string|max:255',
      'note' => 'nullable|string|max:1000',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after:start_date',
      'is_completed' => 'required|boolean',
    ];
  }
}
