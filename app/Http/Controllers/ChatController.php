<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatUserResource;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'users' => ChatUserResource::collection(
                User::query()
                    ->where('id', '!=', $request->user()->id)
                    ->get(['id', 'name', 'profile_photo_path'])
            ),
            'chats' => Chat::query()
                ->where('user_id', $request->user()->id)
                ->whereNotNull('opened_at')
                ->with('interlocutor:id,name,profile_photo_path')
                ->orderBy('opened_at')
                ->get(),
        ]);
    }

    public function show(Request $request, int $interlocutor_id): JsonResponse
    {
        $chat = Chat::updateOrCreate([
            'user_id' => $request->user()->id,
            'interlocutor_id' => $interlocutor_id,
        ], [
            'opened_at' => now(),
        ]);

        return response()->json([
            'messages' => [],
        ]);
    }

    public function destroy(Request $request, int $interlocutor_id): Response
    {
        Chat::where([
            'user_id' => $request->user()->id,
            'interlocutor_id' => $interlocutor_id,
        ])->update(['opened_at' => null]);

        return response()->noContent();
    }
}
