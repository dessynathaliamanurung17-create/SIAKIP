<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];

        if (! $this->user()->isAdmin() && $this->user()->mahasiswa) {
            $rules['asal_kampus']   = ['required', 'string', 'max:150'];
            $rules['jurusan']       = ['required', 'string', 'max:100'];
            $rules['program_studi'] = ['required', 'string', 'max:100'];
            $rules['no_hp']         = ['nullable', 'string', 'max:20'];
            $rules['foto_profil']   = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];
            $rules['hapus_foto']    = ['nullable', 'boolean'];
        }

        return $rules;
    }
}
