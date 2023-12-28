<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChatMessage extends Model
{
    protected $guarded = ['id'];

    public function fromUser(): HasOne|User
    {
        return $this->hasOne(User::class, 'id', 'from_user_id');
    }

    public function toUser(): HasOne|User
    {
        return $this->hasOne(User::class, 'id', 'to_user_id');
    }

    public function toArray($options = 0): array
    {
        return [
            'id' => $this->id,
            'from_user_id' => $this->from_user_id,
            'content' => nl2br($this->content),
            'date' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
