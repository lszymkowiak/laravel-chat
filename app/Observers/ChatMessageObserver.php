<?php

namespace App\Observers;

use App\Events\ChatMessageEvent;
use App\Models\ChatMessage;

class ChatMessageObserver
{
    public function created(ChatMessage $message): void
    {
        ChatMessageEvent::dispatch($message);
    }
}
