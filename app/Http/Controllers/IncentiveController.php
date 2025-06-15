<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\IncentiveRequest;
use App\Models\Award;
use App\Models\Incentive;
use App\Utils\Enum\RecordStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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

    public function edit(int $id)
    {
        try {
            $incentive = Incentive::findOrFail($id);
            return view('dashboard.incentive.edit', [
                'incentive' => $incentive
            ]);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function update(IncentiveRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $incentive = Incentive::findOrFail($id);
            $incentive->point = $validated['point'];
            $incentive->award = $validated['award'];
            $incentive->save();

            return redirect('/dashboard/incentives')->with([
                'message' => 'Incentive updated successfully',
                'variant' => 'success',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Something went wrong',
                'variant' => 'error'
            ]);
        }
    }

    public function incentive_won(): View
    {
        $distributor = Auth::user()->distributor;
        return view('dashboard.incentive.incentive-won', [
            'awards' => Award::where('distributor_id', $distributor->id)->get()
        ]);
    }

    public function awards(): View
    {
        return view('dashboard.incentive.awards', [
            'awards' => Award::orderBy('id', 'desc')->get()
        ]);
    }

    public function approve_award(int $id): RedirectResponse
    {
        try {
            $award = Award::find($id);
            $award->status = RecordStatus::APPROVED->name;
            $award->save();

            return redirect()->back()->with([
                'variant' => 'success',
                'message' => "Successfully approved award"
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'variant' => 'error',
                'message' => "Something went wrong"
            ]);
        }
    }
}
