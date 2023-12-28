<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public readonly ChatMessage $message)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('chat.' . $this->message->to_user_id);
    }

    public function broadcastWith(): array
    {
        return [
            'user' => [
                'id' => $this->message->fromUser->id,
                'name' => $this->message->fromUser->name,
                'profile_photo_url' => $this->message->fromUser->profile_photo_url,
            ],
            'message' => [
                'content' => $this->message->content,
                'date' => $this->message->created_at->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
