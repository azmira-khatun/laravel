<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource. (All Customers List)
     */
    public function index()
    {
        $customers = Customer::paginate(10);

        return view('pages.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource. (Create Form)
     */
    public function create()
    {
        return view('pages.customers.createCustomer');
    }

    /**
     * Store a newly created resource in storage. (Save New Customer)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'contact' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('message', 'Customer created successfully!');
    }

    /**
     * Display the specified resource. (View Customer Details)
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        // viewCustomer.blade.php ফাইলটি লোড করা
        return view('pages.customers.viewCustomer', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource. (Edit Form)
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        // editCustomer.blade.php ফাইলটি লোড করা
        return view('pages.customers.editCustomer', compact('customer'));
    }

    /**
     * Update the specified resource in storage. (Update Customer)
     */
    public function update(Request $request, $id)
    {
        // Data Validation এবং Database-এ Update করার লজিক এখানে লিখুন
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'contact' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('message', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage. (Delete Customer)
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('message', 'Customer deleted successfully!');
    }
}
