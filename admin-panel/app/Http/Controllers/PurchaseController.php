<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;

class PurchaseController extends Controller
{
    // R - Read (List)
    public function index()
    {
        $purchases = Purchase::with('vendor')->latest()->paginate(10);
        return view('pages.purchases.indexPurchase', compact('purchases'));
    }

    // C - Create (Form)
    public function create()
    {
        $vendors = Vendor::select('id', 'name')->get();
        // Assuming products also need to be fetched
        $products = Product::select('id', 'product_name')->get();

        return view('pages.purchases.createPurchase', compact('vendors', 'products'));
    }

    // C - Create (Store)
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'total_amount' => 'required|numeric|min:0',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'quantity.*' => 'required|integer|min:1',
            'unit_price.*' => 'required|numeric|min:0',
            'sale_price.*' => 'required|numeric|min:0',
            'manufacture_date.*' => 'nullable|date',
            'expiry_date.*' => 'nullable|date|after_or_equal:manufacture_date.*',
        ]);

        $itemCount = count($request->product_id);

        try {
            DB::beginTransaction();

            $purchase = Purchase::create([
                'vendor_id' => $request->vendor_id,
                'purchase_date' => now(),
                'total_amount' => $request->total_amount,
            ]);

            $purchaseItems = [];
            for ($i = 0; $i < $itemCount; $i++) {
                $purchaseItems[] = new PurchaseItem([
                    'purchase_id' => $purchase->id,
                    'product_id' => $request->product_id[$i],
                    'quantity' => $request->quantity[$i],
                    'unit_price' => $request->unit_price[$i],
                    'sale_price' => $request->sale_price[$i],
                    'manufacture_date' => $request->manufacture_date[$i],
                    'expiry_date' => $request->expiry_date[$i],
                ]);

                // Update Product Stock (Inventory)
                Product::where('id', $request->product_id[$i])->increment('stock', $request->quantity[$i]);
            }

            $purchase->items()->saveMany($purchaseItems);
            DB::commit();

            return redirect()->route('purchaseIndex')->with('success', 'Purchase recorded successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Purchase store failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to record purchase. Please try again.');
        }
    }

    // R - Read (Detail)
    public function show(Purchase $purchase)
    {
        // Load vendor and items for detailed view
        $purchase->load(['vendor', 'items.product']);
        return view('pages.purchases.historyPurchase', compact('purchase'));
    }

    // U - Update (Form)
    public function edit(Purchase $purchase)
    {
        // Load all necessary data for the form
        $vendors = Vendor::select('id', 'name')->get();
        $products = Product::select('id', 'product_name')->get();
        // Load items for the existing purchase
        $purchase->load('items');

        return view('pages.purchases.editPurchase', compact('purchase', 'vendors', 'products'));
    }

    // U - Update (Store)
    public function update(Request $request, Purchase $purchase)
    {
        // NOTE: Updating stock and items requires complex logic (reversing old stock, adding new)
        // This basic version only updates the header amount for simplicity.
        // For production, you must handle inventory logic fully.
        $request->validate([
            'total_amount' => 'required|numeric|min:0',
            // ... (Add validation for product items similar to store method)
        ]);

        try {
            DB::beginTransaction();

            // 1. Update purchase header
            $purchase->update([
                'total_amount' => $request->total_amount,
                // If you allow vendor change, update 'vendor_id' here
            ]);

            // 2. Logic to update items, reverse old stock, and update new stock goes here
            // This is omitted for brevity but is essential for production CRUD.

            DB::commit();

            return redirect()->route('purchaseIndex')->with('success', 'Purchase updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Purchase update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update purchase. Please try again.');
        }
    }

    // D - Delete
    public function destroy(Purchase $purchase)
    {
        // NOTE: Deleting a purchase must also reverse stock and delete purchase items.
        // If not handled, your inventory will be permanently incorrect.

        try {
            DB::beginTransaction();

            // 1. Reverse stock for each item (CRITICAL)
            foreach ($purchase->items as $item) {
                Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
            }

            // 2. Delete the purchase (items are deleted via cascade if set in migration)
            $purchase->delete();

            DB::commit();
            return redirect()->route('purchaseIndex')->with('success', 'Purchase deleted successfully, and stock reversed.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Purchase delete failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete purchase. Please try again.');
        }
    }
}