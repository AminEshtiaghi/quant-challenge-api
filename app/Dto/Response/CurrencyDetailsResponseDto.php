<?php
declare(strict_types=1);

namespace App\Dto\Response;

class CurrencyDetailsResponseDto
{
    public string $symbol;
    public string $name;
    public float $price;
    public int $market_cap;
    public float $market_cap_dominance;

    public function toArray(): array
    {
        return [
            'symbol' => $this->symbol,
            'name' => $this->name,
            'price' => $this->price,
            'market_cap' => $this->market_cap,
            'market_cap_dominance' => $this->market_cap_dominance,
        ];
    }
}