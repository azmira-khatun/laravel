<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>HasOneThrough</title>
</head>

<body>
    <h1>Categories with their Order (hasOneThrough)</h1>

    <ul>
        @foreach($categories as $cat)
            <li>
                <strong>Category:</strong> {{ $cat->name }} <br>
                <strong>Order:</strong>
                @if($cat->order)
                    {{ $cat->order->name }} (Order ID: {{ $cat->order->id }})
                @else
                    <em>No order for this category</em>
                @endif
            </li>
        @endforeach
    </ul>
</body>

</html>