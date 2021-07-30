<?php

namespace App\Http\Controllers\Search;

use App\Dto\Response\Transformer\CurrencyResponseDtoTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\NomicsService;

class CurrencySearchController extends Controller
{
    private CurrencyResponseDtoTransformer $currencyResponseDtoTransformer;

    public function __construct(CurrencyResponseDtoTransformer $currencyResponseDtoTransformer)
    {
        $this->currencyResponseDtoTransformer = $currencyResponseDtoTransformer;
    }

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
        return $this->currencyResponseDtoTransformer->transformFromArrayItems($currencies);
    }
}