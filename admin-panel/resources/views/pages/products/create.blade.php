@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Product</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Unit</label>
                <select name="productunit_id" class="form-control" required>
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('productunit_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->unit_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Barcode</label>
                <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Save Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection