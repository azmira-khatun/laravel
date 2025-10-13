@extends('master')
@section('content')

    <!-- Header Card -->
    <div class="card mb-4">
        <div class="header pb-5 pt-5 pt-lg-8 d-flex align-items-center"
            style="min-height: 150px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center;">
            <span class="mask bg-gradient-default opacity-8"></span>
            <div class="container-fluid d-flex align-items-center">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-md-10 text-center">
                        <h1 class="display-2 text-white mb-3">Category List</h1>
                        <a href="{{ route('category.create') }}" class="btn btn-info">Add Category</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cats as $cat)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $cat->name }}</td>
                            <td>{{ $cat->price }}</td>
                            <td>
                                <div class="btn-group">
                                    <!-- Edit Button -->
                                    <a href="{{ route('category.edit', ['category_id' => $cat->id]) }}">
                                        <button class="btn btn-success btn-sm me-1 p-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('category.delete') }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="catagory_id" value="{{ $cat->id }}">
                                        <button class="btn btn-danger btn-sm p-1">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection