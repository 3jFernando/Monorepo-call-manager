<?php namespace App\Application\DTOs;

final readonly class IncomingCallDTO 
{
    public function __construct(
        public string $callId,
        public string $phoneNumber,        
        public string $agent,        
        public int $duration,        
        public string $recordingUrl
    ) {}

    public static function fromArray(array $data): self 
    {
        return new self(
            callId: $data['call_id'],
            phoneNumber: $data['phone_number'],
            agent: $data['agent'],
            duration: $data['duration'],
            recordingUrl: $data['recording_url'],
        );
    }

}