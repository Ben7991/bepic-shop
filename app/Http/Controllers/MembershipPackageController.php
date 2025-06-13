<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\MembershipPackageRequest;
use App\Models\MembershipPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MembershipPackageController extends Controller
{
    public function index(): View
    {
        return view('dashboard.membership-package.index', [
            'packages' => MembershipPackage::orderBy('id', 'desc')->get()
        ]);
    }

    public function create(): View | RedirectResponse
    {
        return view('dashboard.membership-package.create');
    }

    public function store(MembershipPackageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            MembershipPackage::create([
                'point' => $this->sanitize($validated['point']),
                'product_quantity' => $this->sanitize($validated['quantity']),
                'price' => $this->sanitize($validated['price']),
            ]);

            return redirect('/dashboard/membership-packages')->with([
                'message' => 'Membership package added successfully',
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
            return view('dashboard.membership-package.edit', [
                'package' => MembershipPackage::findOrFail($id)
            ]);
        } catch (\Exception) {
            return redirect()->back()->with([
                'message' => 'Membership package does not exist',
                'variant' => 'error'
            ]);
        }
    }

    public function update(MembershipPackageRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $package = MembershipPackage::findOrFail($id);
            $package->point = $this->sanitize($validated['point']);
            $package->product_quantity = $this->sanitize($validated['quantity']);
            $package->price = $this->sanitize($validated['price']);
            $package->save();

            return redirect('/dashboard/membership-packages')->with([
                'message' => 'Membership package updated successfully',
                'variant' => 'success'
            ]);
        } catch (\Exception) {
            return redirect()->back()->with([
                'message' => 'Membership package does not exist',
                'variant' => 'error'
            ]);
        }
    }
}
