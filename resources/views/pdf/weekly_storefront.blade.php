<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>Weekly Storefront Sales Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 12px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 25px;
        }

        table th {
            background: #f2f2f2;
            padding: 10px;
            border: 1px solid #ddd;
            font-weight: bold;
            text-align: left;
        }

        table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .totals {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #777;
        }
    </style>
</head>

<body>

<!-- Header -->
<div class="header">
    <div class="title">Weekly Storefront Sales Report</div>
    <div class="subtitle">
        Period:
        {{ now()->subWeek()->format('M d, Y') }}
        —
        {{ now()->format('M d, Y') }}
    </div>
</div>

<!-- Table -->
<table>
    <thead>
    <tr>
        <th>Store Front</th>
        <th>Total Sales (₦)</th>
    </tr>
    </thead>

    <tbody>
    @php $grandTotal = 0; @endphp

    @foreach ($storefronts as $store)
        @php $grandTotal += $store['total_sales']; @endphp

        <tr>
            <td>{{ $store['store_front'] }}</td>
            <td>₦{{ number_format($store['total_sales'], 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Grand Total -->
<div class="totals">
    Grand Total: ₦{{ number_format($grandTotal, 2) }}
</div>

<!-- Footer -->
<div class="footer">
    Generated on {{ now()->format('M d, Y H:i A') }}
</div>

</body>

</html>
