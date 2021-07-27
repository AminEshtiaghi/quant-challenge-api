<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Services\NomicsService;
use Illuminate\Http\JsonResponse;

class CurrencySearchController extends Controller
{
    public function getCurrencies(): JsonResponse
    {
        $currencies = NomicsService::getAll();
        $refinedCurrencies = $this->refineResult($currencies);

        return $this->returnJson([
            'currencies' => $refinedCurrencies
        ]);
    }

    private function refineResult(array $currencies): array
    {
        $result = [];

        foreach ($currencies as $currency) {
            $result[] = [
                'symbol' => $currency['symbol'],
                'name' => $currency['name'],
            ];
        }

        return $result;
    }
}