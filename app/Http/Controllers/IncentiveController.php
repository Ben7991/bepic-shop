<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\IncentiveRequest;
use App\Models\Incentive;
use Illuminate\View\View;

class IncentiveController extends Controller
{
    public function index(): View
    {
        return view('dashboard.incentive.index', [
            'incentives' => Incentive::orderBy('id', 'desc')->get()
        ]);
    }

    public function create(): View
    {
        return view('dashboard.incentive.create');
    }

    public function store(IncentiveRequest $request)
    {
        $validated = $request->validated();

        try {
            Incentive::create([
                'point' => $validated['point'],
                'award' => $validated['award']
            ]);

            return redirect('/dashboard/incentives')->with([
                'message' => 'Incentive added successfully',
                'variant' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Something went wrong',
                'variant' => 'error'
            ]);
        }
    }
}
