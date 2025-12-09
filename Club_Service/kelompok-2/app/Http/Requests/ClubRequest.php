<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ClubRequest extends FormRequest
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
        $rules = [
            'nama' => 'required|string|min:2|max:255',
            'lokasi' => 'required|string|min:2|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'user_id' => 'nullable|integer|exists:users,id',
        ];

        // Pada saat update, field bisa opsional
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules = [
                'nama' => 'sometimes|required|string|min:2|max:255',
                'lokasi' => 'sometimes|required|string|min:2|max:255',
                'deskripsi' => 'nullable|string|max:1000',
                'user_id' => 'nullable|integer|exists:users,id',
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama club wajib diisi',
            'nama.string' => 'Nama club harus berupa teks',
            'nama.min' => 'Nama club minimal :min karakter',
            'nama.max' => 'Nama club maksimal :max karakter',
            'lokasi.required' => 'Lokasi club wajib diisi',
            'lokasi.string' => 'Lokasi club harus berupa teks',
            'lokasi.min' => 'Lokasi club minimal :min karakter',
            'lokasi.max' => 'Lokasi club maksimal :max karakter',
            'deskripsi.string' => 'Deskripsi harus berupa teks',
            'deskripsi.max' => 'Deskripsi maksimal :max karakter',
            'user_id.integer' => 'User ID harus berupa angka',
            'user_id.exists' => 'User tidak ditemukan',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama' => 'Nama Club',
            'lokasi' => 'Lokasi',
            'deskripsi' => 'Deskripsi',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Handle a failed validation attempt for API responses.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        Log::warning('Club validation failed', [
            'correlation_id' => $this->header('X-Correlation-ID'),
            'errors' => $validator->errors()->toArray(),
            'input' => $this->except(['password']),
        ]);

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}

