<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public readonly User $user, public readonly string $message)
    {
    }

    public function broadcastOn(): Channel
    {
        // return new PrivateChannel('chat.' . $this->user->id);
        return new PrivateChannel('chat.1');
    }

    public function broadcastWith(): array
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'profile_photo_url' => $this->user->profile_photo_url,
            ],
            'message' => [
                'content' => $this->message,
                'date' => now()->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
