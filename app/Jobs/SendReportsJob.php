<?php
/*
 *
 *  * © ${YEAR} Demilade Oyewusi
 *  * Licensed under the MIT License.
 *  * See the LICENSE file for details.
 *
 */

namespace App\Jobs;

use App\Mail\StoreFrontWeeklyReportMail;
use App\Mail\WeeklyBooksStockReportMail;
use App\Mail\WeeklyOrdersReport;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendReportsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $emails = setting('reports_emails');

        $start = now()->subWeek()->startOfWeek();
        $end = now()->subWeek()->endOfWeek();

        if (!$emails) {
            Log::info("No emails set");
            return;
        }

        if (setting('send_weekly_order_reports') === 'true') {
            //Orders
            $orders = Order::where('status', 'completed')
                ->whereBetween('created_at', [$start, $end])
                ->get();

            if ($orders->isEmpty()) return;

            // Send email with PDF attachment
            Mail::to($emails)->queue(new WeeklyOrdersReport($orders));
            Log::info("Weekly orders reports queued");
        }


        if (setting('send_weekly_book_reports') === 'true') {
            //Books
            $books = OrderItem::select(
                'book_id',
                DB::raw('SUM(quantity) as total_ordered')
            )
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'completed')
                ->groupBy('book_id')
                ->with([
                    'book:id,title,quantity,image_url'
                ])
                ->orderByDesc('total_ordered')
                ->get()
                ->map(function ($item) {
                    return [
                        'book_id' => $item->book_id,
                        'title' => $item->book->title,
                        'total_ordered' => $item->total_ordered,
                        'stock_left' => $item->book->quantity,
                        'photo' => $item->book->photo ?? null,
                    ];
                });

            if ($books->isEmpty()) return;

            Mail::to($emails)->queue(new WeeklyBooksStockReportMail($books));
            Log::info("Weekly books reports queued");
        }

        if (setting('send_weekly_storefront_reports') === 'true') {

            $results = Order::select('store_front_id')
                ->selectRaw('SUM(total_amount) as total_sales')
                ->where('status', 'completed')
                ->whereBetween('created_at', [now()->subWeek(), now()])
                ->groupBy('store_front_id')
                ->with('storeFront:id,store_name')
                ->get();


            $storefronts = $results->map(function ($item) {
                return [
                    'store_front' => $item->storeFront->store_name ?? 'Unknown',
                    'total_sales' => (float)$item->total_sales,
                ];
            });

            // Send email with PDF attachment
            Mail::to($emails)->queue(new StoreFrontWeeklyReportMail($storefronts));
            Log::info("Weekly storefront reports queued");
        }


    }


}



