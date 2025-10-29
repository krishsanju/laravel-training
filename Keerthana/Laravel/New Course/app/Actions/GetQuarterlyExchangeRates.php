<?php

namespace App\Actions;

use Carbon\Carbon;
use Illuminate\Http\Response;
use App\Clients\ExchangeRateClient;
use App\Http\Responses\ApiResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class GetQuarterlyExchangeRates
{
    use AsAction;

    public function __construct(protected ExchangeRateClient  $client) {}

    public function handle(string $source, string $currencies, Carbon $startDate , Carbon $endDate)
    {
        try{
            $allQuotes = [];
            $currentStart = $startDate->copy();

            while ($currentStart->lte($endDate)) {
                $currentEnd = $currentStart->copy()->addDays(365);
                if ($currentEnd->gt($endDate)) {
                    $currentEnd = $endDate->copy();
                }

                $data = $this->client->getHistoricalRates(
                    $source,
                    $currencies,
                    $currentStart->toDateString(),
                    $currentEnd->toDateString()
                );

                if (!$data || !isset($data['success']) || $data['success'] !== true || empty($data['quotes'])) {
                    return ApiResponse::setMessage('Failed to fetch historical exchange rates.')
                                    ->response(Response::HTTP_BAD_GATEWAY);
                }

                foreach ($data['quotes'] as $date => $dayQuotes) {
                    foreach ($dayQuotes as $pair => $rate) {
                        $targetCurrency = str_replace($data['source'], '', $pair);
                        $allQuotes[$targetCurrency][$date] = $rate;
                    }
                }


                $currentStart = $currentEnd->addDay();
            }
            
            $quarterlyQuotes = array_map(function ($rates) {
                $grouped = array_reduce(array_keys($rates), function ($carry, $date) use ($rates) {
                    $carbon = Carbon::parse($date);
                    $quarterString = $carbon->year . ' Q' . $carbon->quarter;
                    $carry[$quarterString][] = $rates[$date];
                    return $carry;
                }, []);
                return array_map(
                    fn($values) => round(array_sum($values) / count($values), 4),
                    $grouped
                );  
            }, $allQuotes);

            return [
                'status' => true,
                'source' => $source,
                'currencies' => explode(',', $currencies),
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'quotes' => $quarterlyQuotes,
            ];
        }catch (\Exception $e){
            return [
                'status' => false,
            ];
        }
    }
}
