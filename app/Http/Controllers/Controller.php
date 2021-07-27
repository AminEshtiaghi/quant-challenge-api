<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function returnJson(array $data = [], int $code = JsonResponse::HTTP_OK, ?string $message = null): JsonResponse
    {
        if ($code >= 400) {
            if (!$message) {
                $message = 'Oops! something bad happened.';
            }

            $data = array_merge(
                $data,
                [
                    'message' => $message,
                    'errors' => null
                ]
            );
        }

        return response()->json($data, $code);
    }
}
