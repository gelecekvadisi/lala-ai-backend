<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcnooFaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:faqs-create')->only('create', 'store');
        $this->middleware('permission:faqs-read')->only('index');
        $this->middleware('permission:faqs-update')->only('edit', 'update','status');
        $this->middleware('permission:faqs-delete')->only('destroy','deleteAll');
    }

    public function index(Request $request)
    {
        $query = Faq::query();

        if ($request->has('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', $search)
                ->orwhere('answer', 'like', $search);
            });
            $faqs = $query->latest()->get();
            return view('admin.faqs.search', compact('faqs'));
        } else {
            $faqs = $query->latest()->paginate(10);
            return view('admin.faqs.index', compact('faqs'));
        }
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'status' => 'nullable|in:on',
            'answer' => 'required|string',
        ]);

        Faq::create($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);
        return response()->json([
            'message'   => __('Faqs created successfully'),
            'redirect'  => route('admin.faqs.index')
        ]);
    }

    public function edit(string $id)
    {
        $faq = Faq::findOrFail($id);

        return view('admin.faqs.edit', compact('faq'));

    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'question' => 'required|string',
            'status' => 'nullable|in:on',
            'answer' => 'nullable|string',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);
        return response()->json([
            'message'   => __('Faqs updated successfully'),
            'redirect'  => route('admin.faqs.index')
        ]);
    }

    public function destroy(string $id)
    {
        $faq = Faq::findOrFail($id);

        $faq->delete();
        return response()->json([
            'message'   => __('Faqs deleted successfully'),
            'redirect'  => route('admin.faqs.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->update(['status' => $request->status]);
        return response()->json(['message' => 'Faqs']);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');
        DB::beginTransaction();
        try {
            Faq::whereIn('id', $idsToDelete)->delete();
            DB::commit();

            return response()->json([
                'message' => __('Faqs deleted successfully'),
                'redirect' => route('admin.faqs.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }

    }
}
