@extends('master')

@section('content')

    {{-- BEGIN: Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Categories List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
        </ol>
    </nav>
    {{-- END: Breadcrumb --}}

    <div class="card bg-primary-subtle p-5 w-100">
        <div class="bg-info-subtle p-5 rounded w-100 mt-5">
            <div class="d-flex justify-content-center">
                <form method="POST" action="{{ route('editStore') }}" class="w-100" style="max-width: 500px;">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $cat->id }}">

                    <h1 class="text-center mb-4">Update Categories</h1>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required value="{{ $cat->name }}">
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" required value="{{ $cat->price }}">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary form-control">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection