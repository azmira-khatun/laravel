<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Categories, Products & Orders</title>
    <style>
        table {
            width: 70%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        caption {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <table>
        <caption>Categories, Products & Orders</caption>
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Product Name</th>
                <th>Order Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
                @if($cat->products)
                    @foreach($cat->products as $product)
                        <tr>
                            <td>{{ $cat->name }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->order?->name ?? 'No order' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ $cat->name }}</td>
                        <td colspan="2"><em>No products</em></td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>

</html>