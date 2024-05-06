<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditsEarning;
use Illuminate\Http\Request;

class AcnooCreditEarningController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:credits_earnings-read')->only('index');
        $this->middleware('permission:credits_earnings-delete')->only('destroy','deleteAll');
    }

    public function index(Request $request)
    {
        $query = CreditsEarning::query();

        if ($request->has('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('platform', 'like', $search)
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', $search);
                    });
            });

            $credits_earnings = $query->latest()->get();
            return view('admin.credits-earning.search', compact('credits_earnings'));
        } else {
            $credits_earnings = $query->latest()->paginate(10);
            return view('admin.credits-earning.index', compact('credits_earnings'));
        }

    }
    
    public function destroy(CreditsEarning $creditsEarning)
    {
        $creditsEarning->delete();
        return response()->json([
            'message' => __('Buy / Earn Credits deleted successfully.'),
            'redirect' => route('admin.credits-earning.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        CreditsEarning::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('Buy / Earn Credits deleted successfully.'),
            'redirect' => route('admin.credits-earning.index')
        ]);
    }
}
