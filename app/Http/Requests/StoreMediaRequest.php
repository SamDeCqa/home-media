<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreMediaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $docs = ['docx', 'doc', 'odt', 'xls', 'xlsx', 'csv', 'pdf', 'txt', 'ppt', 'pptx'];
        $image = ['jpg', 'png', 'webp', 'jpeg', 'heic', 'svg', 'ico'];
        $video = ['mp4', 'mkv', 'webm'];
        $audio = ['mp3', 'm4a', 'wav', 'ogg', 'aac'];

        $fileTypes = array_merge($docs, $image, $video, $audio);

        return [
            'file' => [
                'required',
                File::types($fileTypes)
            ],
            'is_private' => 'nullable|boolean'
        ];
    }
}
