<?php

namespace App\Http\Controllers\Search;

use App\Dto\Response\Transformer\CurrencyDetailsResponseDtoTransformer;
use App\Dto\Response\CurrencyDetailsResponseDto;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\NomicsService;

class CurrencyDetailsController extends Controller
{
    private CurrencyDetailsResponseDtoTransformer $currencyDetailsResponseDtoTransformer;

    /**
     * the constructor of this controller will be start by instantiating a DTO for using in the next steps.
     *
     * CurrencyDetailsController constructor.
     * @param CurrencyDetailsResponseDtoTransformer $currencyDetailsResponseDtoTransformer
     */
    public function __construct(CurrencyDetailsResponseDtoTransformer $currencyDetailsResponseDtoTransformer)
    {
        $this->currencyDetailsResponseDtoTransformer = $currencyDetailsResponseDtoTransformer;
    }

    /**
     * The only action of this controller which start the process of getting details from the API
     *
     * @param string $symbol
     * @return JsonResponse
     */
    public function getDetails(string $symbol): JsonResponse
    {
        $details = NomicsService::getDetails($symbol);

        if (!empty($details)) {
            $refinedDetails = $this->refineResult($details);

            if (!empty($refinedDetails)) {
                return $this->returnJson($refinedDetails);
            }
        }

        return $this->returnJson([], JsonResponse::HTTP_NOT_FOUND, 'Nothing found for this symbol!');
    }

    /**
     * this function is responsible to convert API output the format which our app is looking for
     *
     * @param array $details
     * @return array
     */
    private function refineResult(array $details): array
    {
        $dto = $this->currencyDetailsResponseDtoTransformer->transformFromArrayItems($details);

        if (!empty($dto)) {
            /** @var CurrencyDetailsResponseDto $itemDto */
            $itemDto = reset($dto);
            return $itemDto->toArray();
        }

        return [];
    }
}