<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Application Deployment Report</title>
    <style>
        body {
            padding-top: 20px;
        }

        .app-section {
            margin-top: 30px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
        }

        .app-header {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center mb-4">
            <h1>Application Deployment Report</h1>
        </div>

        @forelse ($applications as $application)
            <div class="app-section shadow-sm">
                <div class="app-header">
                    <h4 class="mb-0">
                        Application: **{{ $application->name }}** (ID: {{ $application->id }})
                    </h4>
                </div>

                <p class="fw-bold">All Deployments (via HasManyThrough):</p>

                @if ($application->deployments->isEmpty())
                    <p class="text-muted fst-italic">No deployments found for this application across all environments.</p>
                @else
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="table-primary">
                                <th scope="col">#</th>
                                <th scope="col">Commit Hash</th>
                                <th scope="col">Environment (Intermediate)</th>
                                <th scope="col">Deployment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($application->deployments as $deployment)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        <span class="badge bg-secondary">{{ $deployment->commit_hash }}</span>
                                    </td>
                                    <td>
                                        {{-- Deployment Belongs To Environment সম্পর্ক ব্যবহার করে Environment-এর নাম দেখানো হচ্ছে
                                        --}}
                                        @if ($deployment->environment)
                                            {{ $deployment->environment->name }}
                                        @else
                                            (Environment Not Found)
                                        @endif
                                    </td>
                                    <td>{{ $deployment->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @empty
            <div class="alert alert-warning text-center" role="alert">
                No Applications found in the database.
            </div>
        @endforelse
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>