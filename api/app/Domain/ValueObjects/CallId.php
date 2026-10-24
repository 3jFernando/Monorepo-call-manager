<?php namespace App\Domain\ValueObjects;

final readonly class CallId 
{
    public function __construct(public string $value) {}
}