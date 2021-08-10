<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * This service is responsible to connect to the API and provide what we need from it
 *
 * Class NomicsService
 * @package App\Services
 */
class NomicsService
{
    private const CACHE_TTL = 300;

    /**
     * This method is responsible to get a list of current currencies and cache them for 300 minutes
     *
     * @return array
     */
    public static function getAll(): array
    {
        $cacheKey = 'currency:all';
        return Cache::remember($cacheKey, self::CACHE_TTL, function () {

            return self::getAllFrom3rdParty();

        });
    }

    /**
     * this method is responsible to directly connect to the API and return its answer
     *
     * @return array
     */
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

    /**
     * This method is responsible to get details of a specific currency and cache them for 300 minutes
     *
     * @param string $symbol
     * @return array
     */
    public static function getDetails(string $symbol): array
    {
        $cacheKey = "currency:item:$symbol";
        return Cache::remember($cacheKey, self::CACHE_TTL, function ()  use ($symbol) {

            return self::getDetailsFrom3rdParty($symbol);

        });
    }

    /**
     * this method is responsible to directly connect to the API and return its answer
     *
     * @param string $symbol
     * @return array
     */
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

    /**
     * this method is responsible to return amount of volumes from the API and cache it for 300 minutes
     *
     * @param Carbon $startAt
     * @param Carbon|null $endAt
     * @return array
     */
    public static function getVolumes(Carbon $startAt, ?Carbon $endAt): array
    {
        $startAtString = $startAt->toISOString();
        $endAtString = '';
        if ($endAt) {
            $endAtString = ':'.$endAt->toISOString();
        }

        $cacheKey = "currency:item:{$startAtString}{$endAtString}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($startAt, $endAt) {

            return self::getVolumesFrom3rdParty($startAt, $endAt);

        });
    }

    /**
     * this is responsible fo getting volume from the API
     *
     * @param Carbon $startAt
     * @param Carbon|null $endAt
     * @return array
     */
    private static function getVolumesFrom3rdParty(Carbon $startAt, ?Carbon $endAt): array
    {
        $url = config('nomics.url').'/volume/history';
        $query = [
            'key' => config('nomics.key'),
            'start' => $startAt->toISOString(),
        ];

        if ($endAt) {
            $query = array_merge(
                $query,
                [
                    'end' => $endAt->toISOString(),
                ]
            );
        }

        $response = Http::get($url, $query);

        return $response->json();
    }
}