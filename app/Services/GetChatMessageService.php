<?php

namespace App\Services;

use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Builder;

class GetChatMessageService
{
    public static function execute(int $from_user_id, int $to_user_id, ?int $before_id = null)
    {
        // ray()->clearAll()->showQueries();
        return ChatMessage::query()
            ->where(fn (Builder $query) => $query
                ->where(fn (Builder $query) => $query
                    ->where('from_user_id', $from_user_id)
                    ->where('to_user_id', $to_user_id))
                ->orWhere(column: fn (Builder $query) => $query
                    ->where('from_user_id', $to_user_id)
                    ->where('to_user_id', $from_user_id)))
            ->when($before_id, fn (Builder $query) => $query->where('id', '<', $before_id))
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->reverse()
            ->values();
    }
}
