<?php

namespace App\Jobs;

use App\Clients\ExchangeRateClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyExchangeRatesReportMail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchDailyExchangeRatesJob implements ShouldQueue
{
    use Queueable, Dispatchable;
    protected $client;
    protected $currencies;


    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->client = new ExchangeRateClient();
        $this->currencies = config('mail.currencies', ['INR', 'GBP', 'EUR']);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('FETCH DAILY EXCHANGE JOB STARTED '. now());
        $source = 'USD';
        $recipients = config('mail.to', ['kksfeb24@gmail.com']);


        $csvData = [];

        foreach ($this->currencies as $target)
        {
            $response = $this->client->getLiveRate($source, $target);
            if ($response && isset($response['result']))
            {
                $csvData[] = [
                    'date' => now()->toDateString(),
                    'source' => $source,
                    'target' => $target,
                    'rate' => $response['result'],
                ];
            }
        }

        if(empty($csvData))
            {
                Log::warning('No exchange rate data fetched');
                return;
            } 
                

        $filename = storage_path('app/exchange_rates_'. now()->format('Y_m_d').'.csv');
        $file = fopen($filename, 'w');
        fputcsv($file, ['Date', 'Sorce', 'Target','Rate' ]);
        foreach ($csvData as $row)
        {
            fputcsv($file, $row);
        }
        fclose($file);

        info('CSV GENERATED '. $filename);

        foreach($recipients as $email)
        {
            Mail::to($email)
                    ->send(new DailyExchangeRatesReportMail($filename));
        }

        // Mail::to('kksfeb24@gmail.com')->send(new DailyExchangeRatesReportMail($filename));

        info('FETCH DAILY EXCHANGE JOB COMPLETED '. now());

    }
}
