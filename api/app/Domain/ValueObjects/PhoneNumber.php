<?php namespace App\Domain\ValueObjects;

final readonly class PhoneNumber 
{
    public function __construct(public string $value) {}
}