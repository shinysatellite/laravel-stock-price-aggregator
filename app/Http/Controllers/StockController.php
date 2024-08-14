<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function getLatestPrice($symbol)
    {
        $price = Cache::get("stock_price:{$symbol}");

        if (!$price) {
            $stock = Stock::where('symbol', $symbol)->firstOrFail();
            $price = $stock->prices()->latest()->first()->price ?? null;
        }

        return response()->json(['symbol' => $symbol, 'price' => $price]);
    }
}
