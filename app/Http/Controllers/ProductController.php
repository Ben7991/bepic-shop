<?php

namespace App\Http\Controllers;

use App\Http\Dto\ProductPurchaseDtoBuilder;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Referral;
use App\NetworkMarket\CashBonus;
use App\NetworkMarket\CyclePoint;
use App\Utils\Enum\Leg;
use App\Utils\Enum\PurchaseType;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('dashboard.product.index', [
            'products' => Product::orderBy('id', 'desc')->get()
        ]);
    }

    public function create(): View
    {
        return view('dashboard.product.create');
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $imagePath = $request->file('image')->store('products');
            Product::create([
                'name' => $validated['name'],
                'image' => $imagePath,
                'price' => $validated['price'],
                'details' => $validated['details']
            ]);

            return redirect('/dashboard/products')->with([
                'message' => 'Product added successfully',
                'variant' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Something went wrong',
                'variant' => 'error'
            ]);
        }
    }

    public function edit(int $id): View | RedirectResponse
    {
        try {
            $product = Product::findOrFail($id);

            return view('dashboard.product.edit', [
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z ]*$/',
            'price' => 'required|regex:/^[0-9]*(\.[0-9]{2})*$/',
            'details' => 'required'
        ]);

        try {
            $product = Product::findorFail($id);
            $product->name = $validated['name'];
            $product->price = $validated['price'];
            $product->details = $validated['details'];
            $product->save();

            return redirect('/dashboard/products')->with([
                'message' => 'Product updated successfully',
                'variant' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Something went wrong',
                'variant' => 'error'
            ]);
        }
    }

    public function show(int $id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('dashboard.product.show', [
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function purchase(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|numeric',
            'purchase_type' => 'required'
        ]);

        try {
            $purchaseBuilder = (new ProductPurchaseDtoBuilder())
                ->setQuantity($validated['quantity'])
                ->setPurchaseType($validated['purchase_type']);

            $product = Product::find($id);

            if ($product === null)
                throw new \Exception('Product does not exist');

            $user = Auth::user();
            $distributor = $user->distributor;

            $amount = $product->price * $purchaseBuilder->quantity;

            if ($distributor->wallet < $amount)
                throw new \Exception('Insufficient wallet to make this purchase');

            Order::createViaProductPurchase($distributor->id, $product->id, $purchaseBuilder);

            $distributor->wallet -= $amount;

            if ($purchaseBuilder->purchaseType === PurchaseType::MAINTENANCE) {
                $nextMaintenanceDate = Carbon::now()->addDays(30);
                $distributor->next_maintenance = $nextMaintenanceDate;

                $message = 'Order processing and your account has been credited 30days';
            } else {
                $referral = Referral::where('distributor_id', $distributor->id)->first();
                $cashBonus = new CashBonus($referral->upline, $distributor, $amount);
                $cashBonus->awardCashBonus();

                $message = 'Order is processing';
            }
            
            $distributor->save();

            $upline = $distributor->upline;
            $leg = $distributor->leg === Leg::LEFT->name ? Leg::LEFT : Leg::RIGHT;

            $pointCycle = new CyclePoint($upline, $leg, $purchaseBuilder->quantity);
            $pointCycle->cycle();

            return redirect('/dashboard/purchase-history')->with([
                'message' => $message,
                'variant' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => $e->getMessage(),
                'variant' => 'error'
            ]);
        }
    }
}
