<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Models\StockPrice;
use App\Services\AlphaVantageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class FetchStockPrices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $alphaVantageService;

    /**
     * Create a new job instance.
     */
    public function __construct(AlphaVantageService $alphaVantageService)
    {
        //
        $this->alphaVantageService = $alphaVantageService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $stocks = Stock::all();

        foreach ($stocks as $stock) {
            $price = $this->alphaVantageService->fetchStockPrice($stock->symbol);

            if ($price) {
                $previousPrice = $stock->prices()->latest()->first()->price ?? null;
                $percentageChange = $previousPrice ? (($price - $previousPrice) / $previousPrice) * 100 : null;

                $stockPrice = new StockPrice([
                    'price' => $price,
                    'previous_price' => $previousPrice,
                    'percentage_change' => $percentageChange,
                    'timestamp' => now(),
                ]);

                $stock->prices()->save($stockPrice);

                // Update cache
                Cache::put("stock_price:{$stock->symbol}", $price, now()->addMinutes(1));
            }
        }
    }
}
