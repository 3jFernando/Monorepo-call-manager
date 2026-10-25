<?php namespace App\Domain\Events;

use App\Domain\Entities\CallSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class CallReceivedEvent implements ShouldBroadcastNow 
{
    public array $call;

    public function __construct(CallSession $callSession)
    {
        $this->call = $callSession->toArray();
    }

    public function broadcastOn(): array
    {
        return [ new Channel('calls-channel') ];
    }

    public function broadcastAs(): string
    {
        return 'CallReceivedEvent';
    }
}