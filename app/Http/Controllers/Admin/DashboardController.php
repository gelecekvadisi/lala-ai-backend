<?php

namespace App\Http\Controllers\Admin;

use App\Models\CreditsEarning;
use App\Models\Faq;
use App\Models\Plan;
use App\Models\User;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Generate;
use App\Models\Subscribe;
use App\Models\Suggestion;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:dashboard-read')->only('index');
    }

    public function index()
    {
        $users = User::with('plan')->whereRole('user')->where('status', 1)->latest()->take(5)->get();
        return view('admin.dashboard.index', compact('users'));
    }

    public function getDashboardData()
    {
        $data['app_user'] = User::where('role', 'user')->count();
        $data['subscription'] = Plan::count();
        $data['free_subscribers'] = Subscribe::where('price', '<=', 0)->count();
        $data['category'] = Category::count();
        $data['subscribers'] = Subscribe::count();
        $data['banner'] = Banner::count();
        $data['faqs'] = Faq::count();
        $data['suggestions'] = Suggestion::count();
        $data['credit'] = CreditsEarning::sum('credits');
        $data['cost_credits'] = Generate::sum('cost_credits');

        return response()->json($data);

    }

    public function yearlyGenerates()
    {
        $data['texts'] = Generate::whereType('text')
                            ->whereYear('created_at', request('year') ?? date('Y'))
                            ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total_items')
                            ->groupBy('month')
                            ->get();
        
        $data['images'] = Generate::whereType('image')
                            ->whereYear('created_at', request('year') ?? date('Y'))
                            ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total_items')
                            ->orderBy('month')
                            ->groupBy('month')
                            ->get();
        
        return response()->json($data);
    } 

    public function userOverview()
    {
        $data['subscription'] = User::whereYear('created_at', request('year') ?? date('Y'))->whereNotNull('plan_id')->count(); // subscribed_user
        $data['free_user'] = User::whereYear('created_at', request('year') ?? date('Y'))->whereRole('user')->whereNull('plan_id')->count();

        return response()->json($data);
    }
}
