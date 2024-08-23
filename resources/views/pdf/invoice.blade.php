<!-- resources/views/order/invoice.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        /* Define your invoice styling here */
        body {
            font-family: Arial, sans-serif;
        }
        .invoice {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
        }
        .invoice h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <h2>Invoice for Order #{{ $order->id }}</h2>
        <p>Date: {{ $order->created_at->format('Y-m-d') }}</p>
        
        <!-- Display order items in a table -->
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>${{ $item->product->price }}</td>
                    <td>${{ $item->qty * $item->product->price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <p>Total: ${{ $order->total }}</p>
    </div>
</body>
</html>