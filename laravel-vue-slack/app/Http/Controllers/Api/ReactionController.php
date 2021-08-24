<?php

namespace App\Http\Controllers\Api;

use App\Events\ReactionEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReactionRequests\CreateReactionRequest;
use App\Http\Requests\ReactionRequests\UpdateReactionRequest;
use App\Models\Reaction;
use App\Models\Message;
use \Symfony\Component\HttpFoundation\Response;

class ReactionController extends Controller
{
    /**
     * リアクションを更新・作成する
     *
     * @param CreateReactionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrCreate(CreateReactionRequest $request) {
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

        $message = Message::find($request->message_id);
        broadcast(new ReactionEvent('update-reaction', $reactionResult, $message->is_thread_message));
        return response()->json('Reaction update or create completed.', Response::HTTP_OK);
    }

    /**
     * リアクションの回数を+1する
     *
     * @param UpdateReactionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateReactionNumber(UpdateReactionRequest $request) {
        $reaction = Reaction::find($request->reaction_id);
        $reaction->number += 1;
        $reaction->reaction_user_id = $request->user_id;
        $reaction->save();

        $message = Message::find($reaction->message_id);
        broadcast(new ReactionEvent('update-reaction', $reaction, $message->is_thread_message));
        return response()->json('Reaction update completed.', Response::HTTP_OK);
    }
}
