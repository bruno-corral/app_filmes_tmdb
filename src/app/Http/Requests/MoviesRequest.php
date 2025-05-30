<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MoviesRequest extends FormRequest
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
            'tmdb_id' => 'integer',
            'title' => 'required|string|max:255',
            'overview' => 'nullable|string',
            'popularity' => 'nullable|numeric',
            'poster_path' => 'nullable|string',
            'release_date' => 'nullable|string',
            'vote_average' => 'nullable|numeric',
            'vote_count' => 'nullable|integer',
            'adult' => 'nullable|boolean',
            'genre_ids' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute is required!',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'error' => true,
            'message' => array_values($validator->errors()->getMessages())[0][0]
        ]));
    }
}
