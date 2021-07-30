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

    public function __construct(CurrencyDetailsResponseDtoTransformer $currencyDetailsResponseDtoTransformer)
    {
        $this->currencyDetailsResponseDtoTransformer = $currencyDetailsResponseDtoTransformer;
    }

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