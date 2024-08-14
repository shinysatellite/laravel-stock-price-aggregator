<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getStockReport(Request $request)
    {
        $stocks = Stock::with(['prices' => function ($query) {
            $query->latest()->take(2);
        }])->get();

        $report = $stocks->map(function ($stock) {
            $latestPrice = $stock->prices->first();
            $previousPrice = $stock->prices->last();

            return [
                'symbol' => $stock->symbol,
                'name' => $stock->name,
                'current_price' => $latestPrice->price,
                'previous_price' => $previousPrice->price,
                'percentage_change' => $latestPrice->percentage_change,
            ];
        });

        return response()->json($report);
    }
}
