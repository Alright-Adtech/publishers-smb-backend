<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebsitePutRequest extends FormRequest
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
      'state' => 'string|max:255',
      'city' => 'string|max:255',
      'views' => 'integer',
      'website_segment_id' => 'exists:website_segments,id',
    ];
  }
}
