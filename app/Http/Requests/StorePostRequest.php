<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'title' => 'required|string|max:255',
      'content' => 'required|string',
      'category_id' => 'required|exists:categories,id',
      'tags' => 'exists:tags,id',
      'image' => 'nullable|image'
    ];
  }

  /**
   * Get the validation messages.
   *
   * @return array<string, mixed>
   */
  public function messages()
  {
    return [
      'title.required' => 'Il titolo è obbligatorio',
      'title.string' => 'Il titolo deve essere testuale',
      'title.max' => 'Il titolo può essere di :max caratteri massimo',
      'content.required' => 'Il contenuto è obbligatorio',
      'content.string' => 'Il contenuto deve essere testuale',
    ];
  }
}
