<?php namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomingCallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'call_id' => ['required', 'string', 'max:100'],
            'phone_number' => ['required', 'string', 'max:20'],            
            'agent' => ['required', 'string', 'max:150'],            
            'duration' => ['required', 'integer', 'min:0'],            
            'recording_url' => ['required', 'url', 'max:500'],     
        ];
    }
}