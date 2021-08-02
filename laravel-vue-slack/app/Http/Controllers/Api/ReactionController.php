<?php

namespace App\Http\Controllers\Api;

use App\Events\ReactionEvent;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reaction;
use \Symfony\Component\HttpFoundation\Response;

class ReactionController extends Controller
{
    public function updateOrCreate(Request $request) {
        $request->validate([
            'message_id' => 'required',
            'reaction_user_id' => 'required',
            'icon_code' => 'required',
            'icon' => 'required',
        ]);

        $reaction = Reaction::whereMessageId($request->message_id)
                    ->whereIconCode($request->icon_code)->first();

        $reactionResult = Reaction::updateOrCreate(
            [
                'message_id' => $request->message_id,
                'icon_code' => $request->icon_code
            ],
            [
                'message_id' => $request->message_id,
                'reaction_user_id' => $request->reaction_user_id,
                'icon_code' => $request->icon_code,
                'icon' => $request->icon,
                'number' => isset($reaction) ? $reaction->number + 1 : 1,
            ]
        );

        broadcast(new ReactionEvent('update-reaction', $reactionResult));
        return response()->json('Reaction update or create completed.', Response::HTTP_OK);
    }

    public function updateReactionNumber(Request $request) {
        $request->validate([
            'reaction_id' => 'required',
            'user_id' => 'required',
        ]);

        $reaction = Reaction::find($request->reaction_id);
        $reaction->number += 1;
        $reaction->reaction_user_id = $request->user_id;
        $reaction->save();

        broadcast(new ReactionEvent('update-reaction', $reaction));
        return response()->json('Reaction update completed.', Response::HTTP_OK);
    }
}
