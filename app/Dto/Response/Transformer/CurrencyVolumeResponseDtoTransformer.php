<?php
declare(strict_types=1);

namespace App\Dto\Response\Transformer;

use App\Dto\Response\CurrencyVolumeResponseDto;
use Carbon\Carbon;

class CurrencyVolumeResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param array $item
     * @return CurrencyVolumeResponseDto
     */
    public function transformFromItem($item): CurrencyVolumeResponseDto
    {
        $dto = new CurrencyVolumeResponseDto();
        $dto->timestamp = Carbon::parse($item['timestamp']);
        $dto->volume = (int)$item['volume'];
        $dto->spotVolume = (int)$item['spot_volume'];
        $dto->derivativeVolume = (int)$item['derivative_volume'];

        return $dto;
    }
}