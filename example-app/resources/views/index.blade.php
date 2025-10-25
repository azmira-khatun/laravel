<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Blog Posts with Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-center mb-4">All Blog Posts with Comments</h2>

        <table class="table table-bordered table-striped align-middle shadow-sm">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Comments</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->body }}</td>
                        <td>
                            @if($post->comments->count() > 0)
                                <ul class="mb-0">
                                    @foreach($post->comments as $comment)
                                        <li>{{ $comment->content }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">No comments</span>
                            @endif
                        </td>
                        <td>{{ $post->created_at }}</td>
                        <td>{{ $post->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>