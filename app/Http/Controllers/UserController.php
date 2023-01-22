<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    /**
     * Like the user.
     */
    public function likeUser(Request $request, User $userToLike)
    {

        $validator = Validator::make($request->all(), [
            'logged_user_id' => ['required', 'integer', Rule::exists('users', 'id')->where(function ($query) use ($userToLike) {
                return $query->whereNot('id', $userToLike->id);
            })],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Request data validation error.', 'errors' => $validator->errors()], 422);
        }

        $loggedUser = User::where('id', $request->logged_user_id)->firstOrFail();
        $isAlreadyLiked = $userToLike->likedByUser($loggedUser);

        if ($isAlreadyLiked) {
            return response()->json('User already received your like.', 400);
        } else {
            $userToLike->likedByUsers()->attach($loggedUser->id);

            if ($userToLike->likedByUser($loggedUser)) {
                return response()->json('User received your like.', 200);
            } else {
                return response()->json('Something went wrong.', 500);
            }
        }
    }

    /**
     * Dislike the user.
     */
    public function dislikeUser(Request $request, User $userToDislike)
    {

        $validator = Validator::make($request->all(), [
            'logged_user_id' => ['required', 'integer', Rule::exists('users', 'id')->where(function ($query) use ($userToDislike) {
                return $query->whereNot('id', $userToDislike->id);
            })],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Request data validation error.', 'errors' => $validator->errors()], 422);
        }

        $loggedUser = User::where('id', $request->logged_user_id)->firstOrFail();
        $isAlreadyLiked = $userToDislike->likedByUser($loggedUser);

        if (!$isAlreadyLiked) {
            return response()->json('You have not liked this user yet.', 400);
        } else {
            $usersDisliked = $userToDislike->likedByUsers()->detach($loggedUser->id);

            if ($usersDisliked > 0) {
                return response()->json('User disliked.', 200);
            } else {
                return response()->json('Something went wrong.', 500);
            }
        }
    }

}
