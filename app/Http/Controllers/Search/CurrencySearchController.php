<?php

namespace App\Http\Controllers\Search;

use App\Dto\Response\Transformer\CurrencyResponseDtoTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\NomicsService;

class CurrencySearchController extends Controller
{
    private CurrencyResponseDtoTransformer $currencyResponseDtoTransformer;

    /**
     * the constructor of this controller will be start by instantiating a DTO for using in the next steps.
     *
     * CurrencySearchController constructor.
     * @param CurrencyResponseDtoTransformer $currencyResponseDtoTransformer
     */
    public function __construct(CurrencyResponseDtoTransformer $currencyResponseDtoTransformer)
    {
        $this->currencyResponseDtoTransformer = $currencyResponseDtoTransformer;
    }

    /**
     * The only action of this controller which start the process of getting list of currencies from the API
     *
     * @return JsonResponse
     */
    public function getCurrencies(): JsonResponse
    {
        $currencies = NomicsService::getAll();
        $refinedCurrencies = $this->refineResult($currencies);

        return $this->returnJson([
            'currencies' => $refinedCurrencies
        ]);
    }

    /**
     * this function is responsible to convert API output the format which our app is looking for
     *
     * @param array $currencies
     * @return array
     */
    private function refineResult(array $currencies): array
    {
        return $this->currencyResponseDtoTransformer->transformFromArrayItems($currencies);
    }
}