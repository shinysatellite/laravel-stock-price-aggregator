<?php

namespace App\Services;

use App\Facades\AlphaVantage;
use GuzzleHttp\Exception\RequestException;

class AlphaVantageService
{
    public function fetchStockPrice($symbol)
    {
        try {
            $response = AlphaVantage::get('', [
                'query' => [
                    'function' => 'GLOBAL_QUOTE',
                    'symbol' => $symbol,
                    'apikey' => env('ALPHA_VANTAGE_API_KEY'),
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return $data['Global Quote']['05. price'] ?? null;
        } catch (RequestException $e) {
            logger()->error('Alpha Vantage API error: ' . $e->getMessage());
            return null;
        }
    }
}