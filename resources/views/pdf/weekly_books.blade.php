<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Weekly Book Orders</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #e5e7eb;
            padding: 15px 0;
            margin-bottom: 25px;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: top;
        }

        .logo {
            width: 60px;
        }

        .title {
            font-size: 22px;
            margin: 0;
            font-weight: bold;
            color: #111;
        }

        p {
            margin: 4px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th {
            background: #f3f4f6;
            padding: 8px;
            font-weight: bold;
            font-size: 14px;
            border-bottom: 2px solid #e5e7eb;
            text-align: left;
        }

        .table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .cover {
            width: 50px;
            height: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .section-title {
            font-size: 18px;
            margin: 0 0 10px;
            font-weight: bold;
        }

        .low-stock {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <table class="header-table">
        <tr>
            <td style="width: 70px;">
                <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
            </td>

            <td>
                <h1 class="title">Weekly Book Orders Report</h1>
                <p style="color:#555;">Generated on: {{ now()->format('F j, Y') }}</p>
                <p style="color:#555;">Prepared for: Demilade Oyewusi</p>
            </td>

            <td style="text-align:right; color:#555;">
                <strong>Period:</strong><br>
                {{ now()->subWeek()->startOfWeek()->format('M d, Y') }} -
                {{ now()->subWeek()->endOfWeek()->format('M d, Y') }}
            </td>
        </tr>
    </table>
</div>

<!-- MAIN CONTENT -->
<h2 class="section-title">Books Ordered in the Past Week</h2>

<table class="table">
    <thead>
    <tr>
        <th>Cover</th>
        <th>Book Title</th>
        <th>Ordered Qty</th>
        <th>Stock Left</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($books as $item)
        <tr>
            <td>
                @if ($item['photo'])
                    <img src="{{ public_path($item['photo']) }}" class="cover">
                @else
                    <span style="color:#999;">No Image</span>
                @endif
            </td>

            <td>{{ $item['title'] }}</td>

            <td><strong>{{ $item['total_ordered'] }}</strong></td>

            <td class="{{ $item['stock_left'] < 5 ? 'low-stock' : '' }}">
                {{ $item['stock_left'] }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
