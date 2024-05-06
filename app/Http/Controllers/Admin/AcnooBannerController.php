<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\Category;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AcnooBannerController extends Controller
{
    use HasUploader;
    
    public function __construct()
    {
        $this->middleware('permission:banners-create')->only('create', 'store');
        $this->middleware('permission:banners-read')->only('index');
        $this->middleware('permission:banners-update')->only('edit', 'update','status');
        $this->middleware('permission:banners-delete')->only('destroy','deleteAll');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Banner::with('category');

        if ($request->has('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search);
            })
                ->orWhereHas('category', function ($q) {
                    $q->where('name', 'like', '%' . request('search') . '%');
                });

            $banners = $query->latest()->get();
            return view('admin.banners.search', compact('banners'));
        } else {
            $banners = $query->latest()->paginate(10);
            return view('admin.banners.index', compact('banners'));
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->latest()->get();

        return view('admin.banners.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:banners',
            'status' => 'nullable|in:on',
            'category_id' => 'required|exists:categories,id',
            'image'  => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        Banner::create($request->except('image','status') + [
                'image' => $request->image ? $this->upload($request, 'image') : null,
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message' => __('Banner saved successfully'),
            'redirect' => route('admin.banners.index')
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        $categories = Category::where('status', 1)->latest()->get();
        return view('admin.banners.edit',compact('banner','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|unique:banners,title,'.$id,
            'status' => 'nullable|in:on',
            'category_id' => 'required|exists:categories,id',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $banner = Banner::findOrFail($id);

        $banner->update($request->except('image','status') + [
                'image' => $request->image ? $this->upload($request, 'image', $banner->image) : $banner->image,
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message' => __('Banner updated successfully'),
            'redirect' => route('admin.banners.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        if (file_exists($banner->image)) {
            Storage::delete($banner->image);
        }

        $banner->delete();

        return response()->json([
            'message' => __('Banners deleted successfully'),
            'redirect' => route('admin.banners.index')
        ]);

    }

    public function status(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update(['status' => $request->status]);
        return response()->json(['message' => 'Banner']);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');
        DB::beginTransaction();
        try {
            $banners = Banner::whereIn('id', $idsToDelete)->get();
            foreach ($banners as $banner) {
                if (file_exists($banner->image)) {
                    Storage::delete($banner->image);
                }
            }

            Banner::whereIn('id', $idsToDelete)->delete();

            DB::commit();

            return response()->json([
                'message' => __('Banners deleted successfully'),
                'redirect' => route('admin.banners.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }

    }
}
