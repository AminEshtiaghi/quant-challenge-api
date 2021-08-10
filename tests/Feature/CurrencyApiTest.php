<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class CurrencyApiTest extends TestCase
{
    /**
     * check retrieving list of currencies.
     * @test
     * @return void
     */
    public function valid_response_of_currencies(): void
    {
        $token = $this->loginAndGetToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ];
        $response = $this->get('/api/search/currencies', $headers);

        $response->assertOk();

        $responseStructure = [
            'currencies' => [
                '*' => [
                    'symbol',
                    'name',
                ],
            ],
        ];
        $response->assertJsonStructure($responseStructure);
    }

    /**
     * check retrieving market information of currency.
     * @test
     * @return void
     */
    public function valid_response_for_market_information_currency(): void
    {
        $currency = 'BTC';
        $token = $this->loginAndGetToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ];

        $response = $this->get("/api/search/details/$currency", $headers);
        $response->assertOk();

        $responseStructure = [
            'symbol',
            'name',
            'price',
            'market_cap',
            'market_cap_dominance',
        ];
        $response->assertJsonStructure($responseStructure);
    }

    /**
     * check retrieving market information of an invalid currency.
     * @test
     * @return void
     */
    public function invalid_data_for_market_information_currency(): void
    {
        $currency = 'LABLABLAA';
        $token = $this->loginAndGetToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ];

        $response = $this->get("/api/search/details/$currency", $headers);
        $response->assertStatus(404);

        $responseStructure = [
            'message',
            'errors',
        ];
        $response->assertJsonStructure($responseStructure);
    }

    /**
     * @test
     * @return void
     */
    public function invalid_date_for_volume_information(): void
    {
        $queries = [
            'start_at'  => Carbon::now()->addDays(-10)->toISOString(),
            'end_at'    => Carbon::now()->addDays(-20)->toISOString(),
        ];

        $token = $this->loginAndGetToken();
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ];

        $queryStrings = http_build_query($queries);
        $response = $this->get("/api/search/volume?$queryStrings", $headers);
        $response->assertStatus(422);
    }

    /**
     * @test
     * @return void
     */
    public function valid_volume_information(): void
    {
        $queries = [
            'start_at'  => Carbon::now()->addDays(-10)->toISOString(),
        ];

        $token = $this->loginAndGetToken();
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ];

        $queryStrings = http_build_query($queries);
        $response = $this->get("/api/search/volume?$queryStrings", $headers);
        $response->assertOk();

        $responseStructure = [
            '*' => [
                'timestamp',
                'volume',
                'spotVolume',
                'derivativeVolume',
            ],
        ];
        $response->assertJsonStructure($responseStructure);
        $response->assertJsonCount(10);
    }

    /**
     * make a mock login and return its token.
     * @return string
     */
    private function loginAndGetToken(): string
    {
        $credentials = [
            'email' => 'eshtiaghi.amin@gmail.com',
            'password' => 'pleasechangeme',
            'remember' => false,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];
        $response = $this->post('/api/auth/login', $credentials, $headers);
        $response->assertOk();

        $loginResponseStructure = [
            'token',
            'expires_at',
            'name',
        ];
        $response->assertJsonStructure($loginResponseStructure);

        return $response->json('token');
    }
}
