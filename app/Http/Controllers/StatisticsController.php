<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Swagger\Books;
use App\Http\Resources\BestSellersResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\MonthlySalesStatisticsResource;
use App\Http\Responses\ApiResponse;
use App\Models\Book;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;

class StatisticsController extends Controller
{
    public function monthlySalesStatistics(Request $request)
    {
        $year = $request->query('year', now()->year);
        $months = array_fill(1, 12, 0);

        // Query completed orders grouped by month
        $results = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month');

        // Fill the base array
        foreach ($results as $month => $total) {
            $months[$month] = (float)$total;
        }

        $stats = array_values($months);

        $res = Cache::remember('stats_monthly_sales_' . $year, 600, fn() => $stats);


        return new MonthlySalesStatisticsResource($res);
    }


    public function bestSellers(Request $request)
    {
        $year = $request->query('year', now()->year);

        $topBooks = OrderItem::with('book:id,title')
            ->select('book_id')
            ->selectRaw('SUM(quantity) as total_sold')
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->groupBy('book_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $res = Cache::remember('stats_best_sellers_' . $year, 600, fn() => $topBooks);


        return new BestSellersResource($res);
    }

    public function lowAndOutofStock(Request $request)
    {
        $books = Book::where('quantity', '<', 5)
            ->inRandomOrder()
            ->take(5)
            ->get();

        $res = Cache::remember('out_of_stock', 600, fn() => $books);


        return ApiResponse::success(BookResource::collection($res));
    }


}
