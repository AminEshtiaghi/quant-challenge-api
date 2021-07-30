<?php
declare(strict_types=1);

namespace App\Dto\Response\Transformer;

use App\Dto\Response\CurrencyDetailsResponseDto;

class CurrencyDetailsResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param array $item
     * @return CurrencyDetailsResponseDto
     */
    public function transformFromItem($item): CurrencyDetailsResponseDto
    {
        $dto = new CurrencyDetailsResponseDto();
        $dto->symbol = $item['symbol'];
        $dto->name = $item['name'];
        $dto->price = (float)$item['price'];
        $dto->market_cap = (int)$item['market_cap'];
        $dto->market_cap_dominance = (float)$item['market_cap_dominance'];

        return $dto;
    }
}