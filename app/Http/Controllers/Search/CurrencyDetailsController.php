<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Services\NomicsService;
use Illuminate\Http\JsonResponse;

class CurrencyDetailsController extends Controller
{
    public function getDetails(string $symbol): JsonResponse
    {
        $details = NomicsService::getDetails($symbol);

        if (!empty($details)) {
            $refinedDetails = $this->refineResult($details);

            return $this->returnJson($refinedDetails);
        }

        return $this->returnJson([], JsonResponse::HTTP_NOT_FOUND, 'Nothing found for this symbol!');
    }

    private function refineResult(array $details): array
    {
        foreach ($details as $detail) {
            return [
                'symbol' => $detail['symbol'],
                'name' => $detail['name'],
                'price' => $detail['price'],
                'market_cap' => $detail['market_cap'],
                'market_cap_dominance' => $detail['market_cap_dominance'],
            ];
        }
    }
}