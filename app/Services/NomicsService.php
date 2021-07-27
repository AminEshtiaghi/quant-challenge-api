<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class NomicsService
{
    private const CACHE_TTL  = 300;

    public static function getAll(): array
    {
        $cacheKey = 'currency:all';
        return Cache::remember($cacheKey, self::CACHE_TTL, function () {

            return self::getAllFrom3rdParty();

        });
    }

    private static function getAllFrom3rdParty(): array
    {
        $url = config('nomics.url').'/currencies/ticker';
        $query = [
            'key' => config('nomics.key'),
            'interval' => '1d',
            'per-page' => 1000,
            'page' => 1
        ];

        $response = Http::timeout(5)
            ->retry(3, 300)
            ->get($url, $query);

        return $response->json();
    }

    public static function getDetails(string $symbol): array
    {
        $cacheKey = "currency:item:$symbol";
        return Cache::remember($cacheKey, self::CACHE_TTL, function ()  use ($symbol) {

            return self::getDetailsFrom3rdParty($symbol);

        });
    }

    private static function getDetailsFrom3rdParty(string $symbol): array
    {
        $url = config('nomics.url').'/currencies/ticker';
        $query = [
            'key' => config('nomics.key'),
            'ids' => $symbol,
            'interval' => '1d',
            'per-page' => 1,
            'page' => 1
        ];

        $response = Http::get($url, $query);

        return $response->json();
    }
}