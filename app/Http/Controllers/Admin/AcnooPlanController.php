<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class AcnooPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:plans-create')->only('create', 'store');
        $this->middleware('permission:plans-read')->only('index');
        $this->middleware('permission:plans-update')->only('edit', 'update','status');
        $this->middleware('permission:plans-delete')->only('destroy','deleteAll');
    }

    public function index(Request $request)
    {
        $query = Plan::query();

        if ($request->has('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                ->orWhere('subtitle', 'like', $search)
                ->orWhere('price', 'like', $search)
                ->orWhere('duration', 'like', $search);
            });
            $plans = $query->latest()->get();
            return view('admin.plans.search', compact('plans'));
        } else {
            $plans = $query->latest()->paginate(10);
            return view('admin.plans.index', compact('plans'));
        }
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:1500',
            'price' => 'nullable|numeric',
            'duration' => 'required|string',
            'status' => 'nullable|in:on',
        ]);

        Plan::create($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message' => __('Plan created successfully'),
            'redirect' => route('admin.plans.index')
        ]);
    }

    public function edit(string $id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'nullable|in:on',
            'price' => 'nullable|numeric',
            'duration' => 'required|string',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:1500',
        ]);

        $plan = Plan::findOrFail($id);
        $plan->update($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message' => __('Plan updated successfully'),
            'redirect' => route('admin.plans.index')
        ]);
    }

    public function destroy(string $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return response()->json([
            'message'   => __('Plan deleted successfully'),
            'redirect'  => route('admin.plans.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->update(['status' => $request->status]);
        return response()->json(['message' => 'Subscription Plan']);
    }

    public function deleteAll(Request $request)
    {
        Plan::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('Subscription plan deleted successfully'),
            'redirect' => route('admin.plans.index')
        ]);
    }
}
