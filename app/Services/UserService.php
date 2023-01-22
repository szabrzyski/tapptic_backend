<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    /**
     * Like the user.
     */
    public function likeUser(Request $request, User $otherUser)
    {
        $loggedUser = User::where('id', $request->logged_user_id)->firstOrFail();
        $isAlreadyLiked = $otherUser->likedByUser($loggedUser);

        if ($isAlreadyLiked) {
            return response()->json('User already received your like.', 400);
        } else {
            $otherUser->likedByUsers()->attach($loggedUser->id);

            if ($otherUser->likedByUser($loggedUser)) {
                $pairMessage = $loggedUser->likedByUser($otherUser) ? ' You both like each other!' : '';

                return response()->json('User received your like.'.$pairMessage, 200);
            } else {
                return response()->json('Something went wrong.', 500);
            }
        }
    }

    /**
     * Dislike the user.
     */
    public function dislikeUser(Request $request, User $otherUser)
    {
        $loggedUser = User::where('id', $request->logged_user_id)->firstOrFail();
        $isAlreadyLiked = $otherUser->likedByUser($loggedUser);

        if (! $isAlreadyLiked) {
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
