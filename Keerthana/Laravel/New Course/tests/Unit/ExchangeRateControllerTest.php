<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use App\Clients\ExchangeRateClient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExchangeRateControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $clientMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientMock = Mockery::mock(ExchangeRateClient::class);
        $this->app->instance(ExchangeRateClient::class, $this->clientMock);
    }

    public function testFetchesLiveExchangeRateSuccessfull()
    {
        $from = 'EUR';
        $to = 'USD';
        $mockResponse = [
            "query" =>  [
                "from" =>  "EUR",
                "to" =>  "USD",
                "amount" =>  1
                ],
            "result" =>  1.162197
        ];

        $this->clientMock
                ->shouldReceive('getLiveRate')
                ->once()
                ->with($from, $to)
                ->andReturn($mockResponse);

        $response = $this->getJson("/api/rates?from={$from}&to={$to}");

        $response->assertStatus(Response::HTTP_OK)
                ->assertJson([
                    'message' => 'Live exchange rate fetched successfully.',
                    'results' => $mockResponse,
                ]);        
    }

    public function testfetchesLiveExchangeRateFailed()
    {
        $from = 'USD';
        $to = 'INR';

        $this->clientMock
                ->shouldReceive('getLiveRate')
                ->once()
                ->with($from, $to)
                ->andReturnNull();

        $response = $this->getJson("/api/rates?from={$from}&to={$to}");

        $response->assertStatus(Response::HTTP_BAD_GATEWAY)
                ->assertJson([
                    'message' => 'Failed to fetch exchange rate.',
                ]);        
    }

    public function testConvertsCurrencySuccessfully()
    {
        $from = 'USD';
        $to = 'INR';
        $amount = 50;
        $mockResponse = [
            "query" => [
                "from" => "USD",
                "to" => "INR",
                "amount" => 50
            ],
            "result" => 4401.46
        ];

        $this->clientMock
            ->shouldReceive('getLiveRate')
            ->once()
            ->with($from, $to, $amount)
            ->andReturn($mockResponse);

        $response = $this->getJson("/api/rates/convert?from={$from}&to={$to}&amount={$amount}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Currency conversion successful.',
                     'results' => $mockResponse,
                 ]);
    }

    public function testConvertCurrencyFailed()
    {
        $from = 'USD';
        $to = 'EUR';
        $amount = 100;

        $this->clientMock
            ->shouldReceive('getLiveRate')
            ->once()
            ->with($from, $to, (float)$amount)
            ->andReturnNull();

        $response = $this->getJson("/api/rates/convert?from={$from}&to={$to}&amount={$amount}");

        $response->assertStatus(Response::HTTP_BAD_GATEWAY)
                 ->assertJson([
                     'message' => 'Failed to perform currency conversion.',
                 ]);
    }


    public function testSaveFavouriteConversion()
    {
        $user = User::factory()->create();

        $payload = [
            'user_id' => $user->id,
            'from' => 'USD',
            'to' => 'INR',
            'amount' => 50,
            'result' => 4150
        ];

        $response = $this->postJson('/api/rates/convert/save', $payload);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Favourite conversion saved successfully.',
                 ]);

        $this->assertDatabaseHas('favourite_conversions', [
            'user_id' => $user->id,
            'from_currency' => 'USD',
            'to_currency' => 'INR',
            'amount' => 50,
            'converted_amount' => 4150
        ]);
    }

}
