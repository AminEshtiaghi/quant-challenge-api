<?php
declare(strict_types=1);

namespace App\Dto\Response;

use Carbon\Carbon;

class CurrencyVolumeResponseDto
{
    public Carbon $timestamp;
    public int $volume;
    public int $spotVolume;
    public int $derivativeVolume;

    public function toArray(): array
    {
        return [
            'timestamp' => $this->timestamp,
            'volume' => $this->volume,
            'spot_volume' => $this->spotVolume,
            'derivative_volume' => $this->derivativeVolume,
        ];
    }
}