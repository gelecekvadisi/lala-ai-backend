<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HasUploader;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AcnooCategoryController extends Controller
{
    use HasUploader;

    public function __construct()
    {
        $this->middleware('permission:categories-create')->only('create', 'store');
        $this->middleware('permission:categories-read')->only('index');
        $this->middleware('permission:categories-update')->only('edit', 'update','status');
        $this->middleware('permission:categories-delete')->only('destroy','deleteAll');
    }

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search);
            });
            $categories = $query->latest()->get();
            return view('admin.categories.search', compact('categories'));
        } else {
            $categories = $query->latest()->paginate(10);
            return view('admin.categories.index', compact('categories'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories',
            'status' => 'nullable|in:on',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

       Category::create($request->except('image','status') + [
                'image' => $request->image ? $this->upload($request, 'image') : null,
                'status' => $request->status ? 1 : 0,
            ]);
        return response()->json([
            'message'   => __('Category created successfully'),
            'redirect'  => route('admin.categories.index')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $id,
            'status' => 'nullable|in:on',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->except('image','status') + [
                'image' => $request->image ? $this->upload($request, 'image', $category->image) : $category->image,
                'status' => $request->status ? 1 : 0,
            ]);
        return response()->json([
            'message'   => __('Category Updated successfully'),
            'redirect'  => route('admin.categories.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if (file_exists($category->image)) {
            Storage::delete($category->image);
        }
        $category->delete();
        return response()->json([
            'message'   => __('Category deleted successfully'),
            'redirect'  => route('admin.categories.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update(['status' => $request->status]);
        return response()->json(['message' => 'Category']);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');
        DB::beginTransaction();
        try {
            $categories = Category::whereIn('id', $idsToDelete)->get();
            foreach ($categories as $category) {
                if (file_exists($category->value['image'] ?? '')) {
                    Storage::delete($category->value['image']);
                }
            }

            Category::whereIn('id', $idsToDelete)->delete();

            DB::commit();

            return response()->json([
                'message' => __('Category deleted successfully'),
                'redirect' => route('admin.categories.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }

    }

}
