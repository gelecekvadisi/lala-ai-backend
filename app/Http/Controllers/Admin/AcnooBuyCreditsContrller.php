<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuyCredits;
use Illuminate\Http\Request;

class AcnooBuyCreditsContrller extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:buy-credits-read')->only('index');
        $this->middleware('permission:buy-credits-create')->only('create', 'store');
        $this->middleware('permission:buy-credits-delete')->only('destroy','deleteAll');
        $this->middleware('permission:buy-credits-update')->only('edit', 'update','status');
    }

    public function index(Request $request)
    {
        $query = BuyCredits::query();

        if ($request->has('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                ->orWhere('price', 'like', $search)
                ->orWhere('reward', 'like', $search)
                ->orWhere('description', 'like', $search);
            });
            $buy_credits = $query->latest()->get();
            return view('admin.buy-credits.search', compact('buy_credits'));
        } else {
            $buy_credits = $query->latest()->paginate(10);
            return view('admin.buy-credits.index', compact('buy_credits'));
        }
    }

    public function create()
    {
        return view('admin.buy-credits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'price' => 'nullable|numeric',
            'reward' => 'required|numeric|gt:0',
            'title' => 'required|string|max:250',
            'status' => 'nullable|in:on',
            'description' => 'nullable|string|max:1000',
        ]);

        BuyCredits::create($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message' => __('Buy credits created successfully'),
            'redirect' => route('admin.buy-credits.index')
        ]);
    }

    public function edit(string $id)
    {
        $buy_credits = BuyCredits::findOrFail($id);
        return view('admin.buy-credits.edit', compact('buy_credits'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'price' => 'nullable|numeric',
            'reward' => 'required|numeric|gt:0',
            'title' => 'required|string|max:250',
            'status' => 'nullable|in:on',
            'description' => 'nullable|string|max:1000',
        ]);

        $buy_credits = BuyCredits::findOrFail($id);
        $buy_credits->update($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);
        return response()->json([
            'message' => __('Buy credits updated successfully'),
            'redirect' => route('admin.buy-credits.index')
        ]);
    }

    public function destroy(string $id)
    {
        $buy_credits = BuyCredits::findOrFail($id);
        $buy_credits->delete();
        return response()->json([
            'message'   => __('Buy credits deleted successfully'),
            'redirect'  => route('admin.buy-credits.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $buy_credits = BuyCredits::findOrFail($id);
        $buy_credits->update(['status' => $request->status]);
        return response()->json(['message' => 'Buy credits status updated']);
    }

    public function deleteAll(Request $request)
    {
        BuyCredits::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('Buy credits deleted successfully'),
            'redirect' => route('admin.buy-credits.index')
        ]);
    }
}
