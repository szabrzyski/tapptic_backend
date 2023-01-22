<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInteractionRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    /**
     * Like the user.
     */
    public function likeUser(UserInteractionRequest $request, User $otherUser, UserService $userService)
    {
        return $userService->likeUser($request, $otherUser);
    }

    /**
     * Dislike the user.
     */
    public function dislikeUser(UserInteractionRequest $request, User $otherUser, UserService $userService)
    {
        return $userService->dislikeUser($request, $otherUser);
    }
}
