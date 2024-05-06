<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AcnooSuggestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:suggestions-create')->only('create', 'store');
        $this->middleware('permission:suggestions-read')->only('index');
        $this->middleware('permission:suggestions-update')->only('edit', 'update','status');
        $this->middleware('permission:suggestions-delete')->only('destroy','deleteAll');
    }

    public function index(Request $request)
    {
        $query = Suggestion::with('category');

        if ($request->has('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('suggestions', 'like', $search);
            })
                ->orWhereHas('category', function ($q) {
                    $q->where('name', 'like', '%' . request('search') . '%');
                });
            $suggestions = $query->latest()->get();
            return view('admin.suggestions.search', compact('suggestions'));
        } else {
            $suggestions = $query->latest()->paginate(10);
            return view('admin.suggestions.index', compact('suggestions'));
        }
    }

    public function create()
    {
        $categories = Category::where('status', 1)->latest()->get();
        return view('admin.suggestions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|in:on',
            'suggestions' => 'nullable|string',
        ]);

        Suggestion::create($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message'   => __('Suggestion created successfully'),
            'redirect'  => route('admin.suggestions.index')
        ]);
    }

    public function edit(string $id)
    {
        $suggestion = Suggestion::findOrFail($id);
        $categories = Category::where('status', 1)->latest()->get();

        return view('admin.suggestions.edit', compact('suggestion','categories'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|in:on',
            'suggestions' => 'nullable|string',

        ]);
        $suggestion = Suggestion::findOrFail($id);

        $suggestion->update($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);
        return response()->json([
            'message'   => __('Suggestion updated successfully'),
            'redirect'  => route('admin.suggestions.index')
        ]);
    }

    public function destroy(string $id)
    {
        $suggestion = Suggestion::findOrFail($id);

        $suggestion->delete();
        return response()->json([
            'message'   => __('Suggestion deleted successfully'),
            'redirect'  => route('admin.suggestions.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $suggestion = Suggestion::findOrFail($id);
        $suggestion->update(['status' => $request->status]);
        return response()->json(['message' => 'Suggestion']);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');
        DB::beginTransaction();
        try {
            Suggestion::whereIn('id', $idsToDelete)->delete();
            DB::commit();

            return response()->json([
                'message' => __('Suggestion deleted successfully'),
                'redirect' => route('admin.suggestions.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }

    }

}
