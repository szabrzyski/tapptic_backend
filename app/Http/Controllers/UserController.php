<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInteractionRequest;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Like the user.
     */
    public function likeUser(UserInteractionRequest $request, User $otherUser)
    {
        $loggedUser = User::where('id', $request->logged_user_id)->firstOrFail();
        $isAlreadyLiked = $otherUser->likedByUser($loggedUser);

        if ($isAlreadyLiked) {
            return response()->json('User already received your like.', 400);
        } else {
            $otherUser->likedByUsers()->attach($loggedUser->id);

            if ($otherUser->likedByUser($loggedUser)) {
                return response()->json('User received your like.', 200);
            } else {
                return response()->json('Something went wrong.', 500);
            }
        }
    }

    /**
     * Dislike the user.
     */
    public function dislikeUser(UserInteractionRequest $request, User $otherUser)
    {
        $loggedUser = User::where('id', $request->logged_user_id)->firstOrFail();
        $isAlreadyLiked = $otherUser->likedByUser($loggedUser);

        if (!$isAlreadyLiked) {
            return response()->json('You have not liked this user yet.', 400);
        } else {
            $usersDisliked = $otherUser->likedByUsers()->detach($loggedUser->id);

            if ($usersDisliked > 0) {
                return response()->json('User disliked.', 200);
            } else {
                return response()->json('Something went wrong.', 500);
            }
        }
    }

}
