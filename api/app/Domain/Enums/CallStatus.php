<?php namespace App\Domain\Enums;

enum CallStatus: string 
{
    case RINGING = 'ringing';
    case IN_PROGRESS = 'in-progress';
    case COMPLETED = 'completed';
    case SPAM = 'spam';
}