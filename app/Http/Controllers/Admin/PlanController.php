<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function index()
    {
        $plans = MailPlan::orderBy('sort_order')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.form', ['plan' => new MailPlan()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        MailPlan::create($data);
        return redirect()->route('admin.plans.index')->with('success', 'Plan created.');
    }

    public function edit(MailPlan $plan)
    {
        return view('admin.plans.form', compact('plan'));
    }

    public function update(Request $request, MailPlan $plan)
    {
        $data = $this->validated($request, $plan);
        $plan->update($data);
        return redirect()->route('admin.plans.index')->with('success', 'Plan updated.');
    }

    public function destroy(MailPlan $plan)
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted.');
    }

    private function validated(Request $request, ?MailPlan $plan = null): array
    {
        $data = $request->validate([
            'name'        => 'required|string|max:80',
            'description' => 'nullable|string|max:300',
            'price_kes'   => 'required|integer|min:0',
            'storage_mb'  => 'required|integer|min:1',
            'max_domains' => 'nullable|integer|min:1',
            'features'    => 'required|string',   // newline-separated list from textarea
            'is_featured' => 'boolean',
            'is_active'   => 'boolean',
            'sort_order'  => 'required|integer|min:0',
        ]);

        // Convert newline-separated features to array
        $data['features'] = array_values(array_filter(
            array_map('trim', explode("\n", $data['features']))
        ));

        // Derive slug from name (only on create, or if name changed)
        if (! $plan || $plan->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active');

        return $data;
    }
}
