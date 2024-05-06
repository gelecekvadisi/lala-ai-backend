<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriberController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:subscribers-read')->only('index');
        $this->middleware('permission:subscribers-delete')->only('destroy','deleteAll');
    }

    public function index(Request $request)
    {
        $query = Subscribe::with('plan:id,title,price', 'user:id,name');

        if ($request->has('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->orWhereHas('plan', function ($q) use ($search) {
                    $q->where('title', 'like', $search)
                        ->orWhere('price', 'like', $search);
                })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', $search);
                    });
            });

            $subscribers = $query->latest()->get();
            return view('admin.subscribers.search', compact('subscribers'));
        } else {
            $subscribers = $query->latest()->paginate(10);
            return view('admin.subscribers.index', compact('subscribers'));
        }
    }

    public function destroy(string $id)
    {
        Subscribe::findOrFail($id)->delete();
        return response()->json([
            'message' => __('Subscribes deleted successfully.'),
            'redirect' => route('admin.subscribers.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        Subscribe::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('Subscribes deleted successfully.'),
            'redirect' => route('admin.subscribers.index')
        ]);
    }
}
