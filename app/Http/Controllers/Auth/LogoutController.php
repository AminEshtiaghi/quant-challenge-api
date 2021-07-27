<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class LogoutController extends Controller
{
    public function do()
    {
        /** @var User $user */
        $user = auth()->user();

        $user->token()->delete();

        return $this->returnJson();
    }
}