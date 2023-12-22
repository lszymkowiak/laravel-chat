<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatUserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'users' => ChatUserResource::collection(
                User::query()
                    ->where('id', '!=', $request->user()->id)
                    ->get(['id', 'name', 'profile_photo_path'])
            ),
        ]);
    }
}
