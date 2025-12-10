<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitScoreRequest extends FormRequest
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
            'session_id' => 'required|string',
            'token' => 'required|string',
            'score' => 'required|integer|min:0',
            'game_time_ms' => 'required|integer|min:0',
            'signature_hash' => 'required|string',
            'validation_nonce' => 'required|string',
            'session_data' => 'required|array',
            'session_data.obstacles_passed' => 'required|integer|min:0',
            'session_data.jumps' => 'required|integer|min:0',
            'session_data.collisions' => 'required|integer|min:0|max:4',
            'session_data.checkpoints' => 'required|array',
            'session_data.checkpoints.*.timestamp' => 'required|integer|min:0',
            'session_data.checkpoints.*.score' => 'required|integer|min:0',
            'session_data.checkpoints.*.gameTime' => 'required|integer|min:0',
            'session_data.signature_timestamp' => 'required|integer|min:0',
        ];

    }
}
