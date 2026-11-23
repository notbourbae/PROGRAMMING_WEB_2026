<?php

namespace App\Http\Requests;

use App\Models\Media;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $method = $this->isMethod('post') ? 'required' : 'sometimes';
        $medium = $this->route('medium');
        $mediaId = $medium instanceof Media ? $medium->getKey() : $medium;

        return [
            'title' => [$method, 'string', 'max:255', Rule::unique('media', 'title')->ignore($mediaId)],
            'type' => [$method, 'string', 'max:100'],
            'genre' => [$method, 'string', 'max:100'],
            'rating' => [$method, 'numeric', 'min:0', 'max:100'],
            'episodes' => ['nullable', 'integer', 'min:1'],
            'studio' => ['nullable', 'string', 'max:150'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi.',
            'title.string' => 'Judul media harus berupa teks.',
            'title.max' => 'Judul media maksimal 255 karakter.',
            'title.unique' => 'Judul media sudah digunakan.',
            'type.required' => 'Jenis media wajib diisi.',
            'type.string' => 'Jenis media harus berupa teks.',
            'type.max' => 'Jenis media maksimal 100 karakter.',
            'genre.required' => 'Genre wajib diisi.',
            'genre.string' => 'Genre harus berupa teks.',
            'genre.max' => 'Genre maksimal 100 karakter.',
            'rating.required' => 'Rating wajib diisi.',
            'rating.numeric' => 'Rating harus berupa angka.',
            'rating.min' => 'Rating minimal 0.',
            'rating.max' => 'Rating maksimal 100.',
            'episodes.integer' => 'Jumlah episode harus berupa bilangan bulat.',
            'episodes.min' => 'Jumlah episode minimal 1.',
            'studio.string' => 'Studio harus berupa teks.',
            'studio.max' => 'Nama studio maksimal 150 karakter.',
        ];
    }
}
