<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcnooApiKeyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:api-keys-create')->only('create', 'store');
        $this->middleware('permission:api-keys-read')->only('index');
        $this->middleware('permission:api-keys-update')->only('edit', 'update','status');
        $this->middleware('permission:api-keys-delete')->only('destroy','deleteAll');
    }

    public function index(Request $request)
    {
        $query = ApiKey::query();

        if ($request->has('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('key', 'like', $search)
                    ->orwhere('title', 'like', $search);
            });
            $api_keys = $query->latest()->get();
            return view('admin.api-keys.search', compact('api_keys'));
        } else {
            $api_keys = $query->latest()->paginate(10);
            return view('admin.api-keys.index', compact('api_keys'));
        }
    }

    public function create()
    {
        $api_keys = ApiKey::where('status', 1)->latest()->get();
        return view('admin.api-keys.create', compact('api_keys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:api_keys',
            'title' => 'nullable|string',
            'status' => 'nullable|in:on',
        ]);
        ApiKey::create($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);
        return response()->json([
            'message'   => __('Api Key created successfully'),
            'redirect'  => route('admin.api-keys.index')
        ]);
    }

    public function edit(string $id)
    {
        $api_key = ApiKey::findOrFail($id);

        return view('admin.api-keys.edit', compact('api_key'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'key' => 'required|string|unique:api_keys,key,'.$id,
            'title' => 'nullable|string',
            'status' => 'nullable|in:on',
        ]);
        $api_key = ApiKey::findOrFail($id);

        $api_key->update($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);
        return response()->json([
            'message'   => __('Api Key updated successfully'),
            'redirect'  => route('admin.api-keys.index')
        ]);
    }

    public function destroy(string $id)
    {
        $api_key = ApiKey::findOrFail($id);

        $api_key->delete();
        return response()->json([
            'message'   => __('Api Key deleted successfully'),
            'redirect'  => route('admin.api-keys.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $api_key = ApiKey::findOrFail($id);
        $api_key->update(['status' => $request->status]);
        return response()->json(['message' => 'Api Key']);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');
        DB::beginTransaction();
        try {
            ApiKey::whereIn('id', $idsToDelete)->delete();
            DB::commit();

            return response()->json([
                'message' => __('Api Key deleted successfully'),
                'redirect' => route('admin.api-keys.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }

    }
}
