<!DOCTYPE html>
<html>
<head>
    <title>Weekly Orders Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        p.period {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tfoot td {
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Weekly Orders Report</h2>

<p class="period">
    Period: {{ now()->subWeek()->startOfWeek()->format('M d, Y') }} -
    {{ now()->subWeek()->endOfWeek()->format('M d, Y') }}
</p>

@if($orders->isEmpty())
    <p>No completed orders found for this period.</p>
@else
    <table>
        <thead>
        <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Total Amount</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>${{ number_format($order->total_amount, 2) }}</td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2">Grand Total</td>
            <td colspan="2">
                ${{ number_format($orders->sum('total_amount'), 2) }}
            </td>
        </tr>
        </tfoot>
    </table>
@endif

</body>
</html>
