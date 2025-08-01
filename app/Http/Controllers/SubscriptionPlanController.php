<?php

namespace App\Http\Controllers;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;



class SubscriptionPlanController extends Controller
{
    public function plans()
    {
        $plans = SubscriptionPlan::latest()->paginate(10);
        return view('admin.pricing', compact('plans'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|in:artist,label,listener,admin', // adjust roles as needed
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|string|in:monthly,yearly',
            'description' => 'nullable|string',
            'currency' => 'required|string|size:3', // ISO 4217 code
        ]);

        SubscriptionPlan::create($validated);

        return redirect()->route('admin.pricing.plans')->with('success', 'Plan created successfully.');
    }

    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.show', compact('subscriptionPlan'));
    }

    public function editPlan(SubscriptionPlan $plan)
    {
        return view('admin.edit', compact('plan'));
    }

    public function updatePlan(Request $request, SubscriptionPlan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|in:artist,label,listener,admin',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|string|in:monthly,yearly',
            'description' => 'nullable|string',
            'currency' => 'required|string|size:3',
        ]);

        $plan->update($validated);

        return redirect()->route('admin.pricing.plans')->with('success', 'Plan updated successfully.');
    }

    public function deletePlan(SubscriptionPlan $plan)
    {
        $plan->delete();

        return redirect()->route('admin.pricing.plans')->with('success', 'Plan deleted successfully.');
    }
}
