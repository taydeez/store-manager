@extends('mails.layouts.main')

@section('title', 'Your Sales Receipt')
@section('subtitle', 'Thank you for your purchase!')

@section('content')
    <h2>Order Summary</h2>

    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>

    <table width="100%" cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; margin-top: 10px;">
        <thead style="background-color: #f9fafb;">
        <tr>
            <th align="left">Item</th>
            <th align="center">Qty</th>
            <th align="right">Price</th>
            <th align="right">Sub Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->book->title }}</td>
                <td align="center">{{ $item->quantity }}</td>
                <td align="right">{{ $item->unit_price }}</td>
                <td align="right">${{ number_format($item->unit_price * $item->quantity, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p style="text-align: right; font-weight: bold; margin-top: 15px;">
        Total: ${{ number_format($order->total_amount, 2) }}
    </p>

@endsection
