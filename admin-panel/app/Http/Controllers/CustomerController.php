<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth; // Auth Facade ব্যবহার করতে এটি যোগ করা হয়েছে

class CustomerController extends Controller
{
    public function index()
    {
        // For security and performance, only authenticated users can view the index
        if (!Auth::check()) {
            return redirect('/login');
        }

        $customers = Customer::paginate(10);
        return view('pages.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('pages.customers.createCustomer');
    }

    public function store(Request $request)
    {
        // 1. Validation updated to use 'phone' and database constraints
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email|max:100',
            'phone' => 'nullable|string|max:20', // 'contact' থেকে 'phone' এ পরিবর্তন করা হয়েছে
            'address' => 'nullable|string',
        ]);

        // 2. Set the user_id to the currently authenticated user
        $validatedData['user_id'] = Auth::id();
        // Note: For this to work, the Customer model must have 'user_id' in its $fillable array.

        Customer::create($validatedData);

        return redirect()->route('customerIndex')->with('message', 'Customer created successfully!');
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages.customers.viewCustomer', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages.customers.editCustomer', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        // Validation updated to use 'phone'
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id . '|max:100',
            'phone' => 'nullable|string|max:20', // 'contact' থেকে 'phone' এ পরিবর্তন করা হয়েছে
            'address' => 'nullable|string',
        ]);

        // user_id should not be updated after creation, so we only update validated fields
        $customer->update($validatedData);

        return redirect()->route('customerIndex')->with('message', 'Customer updated successfully!');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customerIndex')->with('message', 'Customer deleted successfully!');
    }
}
