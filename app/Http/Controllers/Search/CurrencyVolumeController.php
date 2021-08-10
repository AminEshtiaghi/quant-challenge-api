<?php

namespace App\Http\Controllers\Search;

use App\Dto\Response\Transformer\CurrencyVolumeResponseDtoTransformer;
use App\Services\NomicsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CurrencyVolumeController extends Controller
{
    private CurrencyVolumeResponseDtoTransformer $currencyVolumeResponseDtoTransformer;

    /**
     * constructor is responsible to create an instantiation of related DTO
     *
     * CurrencyVolumeController constructor.
     * @param CurrencyVolumeResponseDtoTransformer $currencyVolumeResponseDtoTransformer
     */
    public function __construct(CurrencyVolumeResponseDtoTransformer $currencyVolumeResponseDtoTransformer)
    {
        $this->currencyVolumeResponseDtoTransformer = $currencyVolumeResponseDtoTransformer;
    }

    /**
     * this is the main action of the controller
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function get(Request $request): JsonResponse
    {
        $this->doValidation($request);

        try {
            $startAt = $request->get('start_at');
            $endAt = $request->get('end_at');

            $startAtCarbon = Carbon::parse($startAt);
            $endAtCarbon = null;
            if ($endAt) {
                $endAtCarbon = Carbon::parse($endAt);
            }

            $apiResult = NomicsService::getVolumes($startAtCarbon, $endAtCarbon);
            $dto = $this->refineResult($apiResult);

            return $this->returnJson(
                [
                    'result' => $dto,
                ]
            );

        } catch (Throwable $exception) {
            Log::error($exception);
            return $this->returnJson([], JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'Oops! something bad happened!');
        }
    }

    /**
     * this method is responsible for validating all the input of request
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    private function doValidation(Request $request): void
    {
        $rules = [
            'start_at'  => ['required', 'date'],
            'end_at'    => ['nullable', 'date', 'after_or_equal:start_at']
        ];

        $this->validate($request, $rules);
    }

    /**
     * this method is responsible to return DTO array of converting API result to the client appropriate one
     *
     * @param array $apiResult
     * @return array
     */
    private function refineResult(array $apiResult): array
    {
        return $this->currencyVolumeResponseDtoTransformer->transformFromArrayItems($apiResult);
    }
}
