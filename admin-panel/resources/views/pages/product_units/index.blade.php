@extends('master')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Product Units List</h3>
                <a href="{{ route('productUnitCreate') }}" class="btn btn-primary btn-sm">+ Add New Unit</a>
            </div>

            <div class="card-body">
                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Unit Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $key => $unit)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $unit->unit_name }}</td>
                                <td>{{ $unit->description }}</td>
                                <td>
                                    <a href="{{ route('productUnitEdit', $unit->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('productUnitDelete', $unit->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure to delete this unit?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($units->isEmpty())
                    <p class="text-center mt-3 text-muted">No Product Units Found</p>
                @endif
            </div>
        </div>
    </div>
@endsection