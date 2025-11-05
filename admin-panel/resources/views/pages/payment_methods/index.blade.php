@extends('master')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Payment Methods</h1>
        <a href="{{ route('paymentMethodCreate') }}" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
            + Add New Method
        </a>
    </div>

    @if (session('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Method Name</th>
                        <th class="py-3 px-6 text-center">Active</th>
                        <th class="py-3 px-6 text-center">Created At</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($paymentMethods as $method)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $method->id }}</td>
                            <td class="py-3 px-6 text-left">{{ $method->method_name }}</td>
                            <td class="py-3 px-6 text-center">
                                <span class="relative inline-block px-3 py-1 font-semibold text-{{ $method->is_active ? 'green' : 'red' }}-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-{{ $method->is_active ? 'green' : 'red' }}-200 opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $method->is_active ? 'Yes' : 'No' }}</span>
                                </span>
                            </td>
                            <td class="py-3 px-6 text-center">{{ $method->created_at->format('Y-m-d') }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('paymentMethodShow', $method->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" title="View">
                                        <!-- View Icon (SVG or Icon Library) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <a href="{{ route('paymentMethodEdit', $method->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" title="Edit">
                                        <!-- Edit Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                    <form action="{{ route('paymentMethodDelete', $method->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment method? This action cannot be undone and may affect linked transactions.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110" title="Delete">
                                            <!-- Delete Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $paymentMethods->links() }}
        </div>
    </div>
</div>
@endsection
