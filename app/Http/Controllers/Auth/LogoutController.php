<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    /**
     * The only action of this controller which start the process of logout
     *
     * @return JsonResponse
     */
    public function do(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $user->token()->delete();

        return $this->returnJson();
    }
}