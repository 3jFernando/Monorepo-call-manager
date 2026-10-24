<?php namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class CallModel extends Model
{
    protected $table = 'calls';

    protected $fillable = [
        'call_id',
        'phone_number',
        'agent',
        'duration',
        'recording_url',
        'has_called_before',
        'is_spam'
    ];

    protected $casts = [
        'has_called_before' => 'boolean',
        'is_spam' => 'boolean',
        'duration' => 'integer'
    ];
}