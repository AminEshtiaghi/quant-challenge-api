<?php
declare(strict_types=1);

namespace App\Dto\Response\Transformer;

use App\Dto\Response\CurrencyResponseDto;

class CurrencyResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param array $item
     * @return CurrencyResponseDto
     */
    public function transformFromItem($item): CurrencyResponseDto
    {
        $dto = new CurrencyResponseDto();
        $dto->symbol = $item['symbol'];
        $dto->name = $item['name'];

        return $dto;
    }
}