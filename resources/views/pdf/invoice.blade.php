<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->id }}</title>
    <style> body{font-family: DejaVu Sans, sans-serif;} table{width:100%;border-collapse:collapse} td,th{border:1px solid #ddd;padding:6px} </style>
</head>
<body>
<h2>{{ $invoice->title }}</h2>
<p>Client: {{ $invoice->client->name }}</p>
<p>Due: {{ optional($invoice->due_date)->format('Y-m-d') }}</p>

<table>
    <thead><tr><th>#</th><th>Name</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>
    <tbody>
    @foreach($invoice->items as $i => $it)
        @php $qty = $it['qty'] ?? 1; @endphp
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $it['name'] }}</td>
            <td>{{ $qty }}</td>
            <td>{{ $it['price'] }} {{ $invoice->currency }}</td>
            <td>{{ $it['price'] * $qty }} {{ $invoice->currency }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p>Subtotal: {{ $invoice->subtotal }} {{ $invoice->currency }}</p>
<p>Tax: {{ $invoice->tax }} {{ $invoice->currency }}</p>
<p>Discount: {{ $invoice->discount }} {{ $invoice->currency }}</p>
<h3>Total: {{ $invoice->total }} {{ $invoice->currency }}</h3>
<p>Status: {{ strtoupper($invoice->status) }}</p>
</body>
</html>
