@extends('master')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-xl">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Add New Payment Method</h1>

        <form action="{{ route('paymentMethodStore') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="method_name" class="block text-sm font-medium text-gray-700 mb-1">Method Name <span class="text-red-500">*</span></label>
                <input type="text" name="method_name" id="method_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('method_name') border-red-500 @enderror" value="{{ old('method_name') }}" required>
                @error('method_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                <label for="is_active" class="ml-2 block text-sm text-gray-900">Is Active</label>
                @error('is_active')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('paymentMethodIndex') }}" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-300">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                    Save Method
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
