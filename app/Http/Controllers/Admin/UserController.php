<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\User;
use App\Models\Subscribe;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use HasUploader;

    public function __construct()
    {
        $this->middleware('permission:users-create')->only('create', 'store');
        $this->middleware('permission:users-read')->only('index');
        $this->middleware('permission:users-update')->only('edit', 'update','status');
        $this->middleware('permission:users-delete')->only('destroy','deleteAll');
    }

    public function index(Request $request)
    {
        $query = User::with('plan');

        if ($request->has('search') ) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search)
                    ->orWhereHas('plan', function ($q) use ($search) {
                        $q->where('duration', 'like', $search);
                    });
            });

            if ($request->has('type')) {
                $type = $request->input('type');
                if ($type === 'user') {
                    $query->where('role', 'user');
                } elseif ($type === 'admin') {
                    $query->whereNotIn('role', ['superadmin', 'user']);
                }
            }

            $users = $query->latest()->get();
            return view('admin.users.search', compact('users'));
        } else {
            $query->when(request('type') === 'user', function ($q) {
                return $q->where('role', 'user');
            })
                ->when(request('type') === 'admin', function ($q) {
                    return $q->whereNotIn('role', ['superadmin', 'user']);
                });

            $users = $query->latest()->paginate(10);
            $users->appends(['type' => request('type')]);

            return view('admin.users.index', compact('users'));
        }
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['superadmin', 'user'])->latest()->get();
        $plans = Plan::where('status', 1)->latest()->get();
        return view('admin.users.create', compact('plans','roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string',
            'username' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'plan_id' => 'required_if:role,user',
            'password' => 'required|string|min:6',
            'will_expire' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {

            if (($request->role == '' || $request->role == 'user') && $request->plan_id) {
                $plan = Plan::findOrFail($request->plan_id);
                $duration_in_days = $plan->duration == 'yearly' ? 365 : ($plan->duration == '6_monthly' ? 180 : ($plan->duration == '3_monthly' ? 90 : ($plan->duration == 'monthly' ? 30 : ($plan->duration == '15_days' ? 15 : ($plan->duration == 'weekly' ? 7 : 0)))));
                $duration_in_days = now()->addDays($duration_in_days);
            }

            $user = User::create($request->except('image', 'password', 'role') + [
                'role' => $request->role ?? 'user',
                'will_expire' => $duration_in_days ?? null,
                'password' => Hash::make($request->password),
                'image' => $request->image ? $this->upload($request, 'image') : null,
            ]);

            if (($request->role == '' || $request->role == 'user') && $request->plan_id) {
                Subscribe::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'price' => $plan->price,
                    'will_expire' => $duration_in_days ?? null,
                ]);
                sendNotification($user->id, route('admin.users.index', ['id' => $user->id, 'type' => 'user']), __('New user registerd.'), $user);
            }

            DB::commit();
            return response()->json([
                'message'   => __('User created successfully'),
                'redirect'  => route('admin.users.index', ['type' => $request->type])
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(__('Something was wrong, Maybe you have lost your connection.'), 403);
        }
    }

    public function edit(string $id)
    {
        $roles = Role::where('name', '!=', 'superadmin')->latest()->get();
        $plans = Plan::where('status', 1)->latest()->get();
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('plans','user', 'roles'));

    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string',
            'username' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'plan_id' => 'required_if:role,user',
            'password' => 'nullable|string|min:6',
            'will_expire' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {

            if (($request->role == '' || $request->role == 'user') && $request->plan_id) {
                $plan = Plan::findOrFail($request->plan_id);
                $duration_in_days = $plan->duration == 'yearly' ? 365 : ($plan->duration == '6_monthly' ? 180 : ($plan->duration == '3_monthly' ? 90 : ($plan->duration == 'monthly' ? 30 : ($plan->duration == '15_days' ? 15 : ($plan->duration == 'weekly' ? 7 : 0)))));
                $duration_in_days = now()->addDays($duration_in_days);
            }

            $user = User::findOrFail($id);

            $user->update($request->except('image', 'password', 'role') + [
                'role' => $request->role ?? 'user',
                'will_expire' => $duration_in_days ?? null,
                'password' => Hash::make($request->password),
                'image' => $request->image ? $this->upload($request, 'image', $user->image) : $user->image,
            ]);

            if (($request->role == '' || $request->role == 'user') && $request->plan_id) {
                Subscribe::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'price' => $plan->price,
                    'will_expire' => $duration_in_days ?? null,
                ]);
                sendNotification($user->id, route('admin.users.index', ['id' => $user->id, 'type' => 'user']), __('User has been updated.'), $user);
            }

            DB::commit();
            return response()->json([
                'message'   => __('User updated successfully'),
                'redirect'  => route('admin.users.index', ['type' => $request->type])
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(__('Something was wrong, Maybe you have lost your connection.'), 403);
        }
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if (file_exists($user->image)) {
            Storage::delete($user->image);
        }
        $user->delete();
        return response()->json([
            'message'   => __('User deleted successfully'),
            'redirect'  => route('admin.users.index',['type' => request('type')])
        ]);
    }

    public function status(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => $request->status]);
        return response()->json(['message' => 'User Status']);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');
        DB::beginTransaction();
        try {
            $users = User::whereIn('id', $idsToDelete)->get();
            foreach ($users as $user) {
                if (file_exists($user->value['image'] ?? '')) {
                    Storage::delete($user->value['image']);
                }
            }

            User::whereIn('id', $idsToDelete)->delete();

            DB::commit();

            return response()->json([
                'message' => __('User deleted successfully'),
                'redirect' => url()->previous(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }

    }

}
