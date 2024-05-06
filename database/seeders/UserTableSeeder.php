<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $free_plan = Plan::where('price', '<=', 0)->first();

        if ($free_plan) {
            $duration_in_days = $free_plan->duration == 'yearly' ? 365 : ($free_plan->duration == '6_monthly' ? 180 : ($free_plan->duration == '3_monthly' ? 90 : ($free_plan->duration == 'monthly' ? 30 : ($free_plan->duration == '15_days' ? 15 : ($free_plan->duration == 'weekly' ? 7 : 0)))));
            $duration_in_days = now()->addDays($duration_in_days);
        }

        $users = array(
            array('name' => 'User', 'role' => 'user', 'username' => 'user', 'email' => 'user@user.com', 'phone' => NULL,'image' => 'https://avatars.dicebear.com/api/adventurer/user.svg', 'lang' => 'en', 'credits' => 0, 'status' => 1, 'will_expire' => $duration_in_days ?? null, 'plan_id' => $free_plan->id ?? null, 'email_verified_at' => now(), 'password' => bcrypt('user'), 'remember_token' => NULL, 'created_at' => now(), 'updated_at' => now())
        );
        
        User::insert($users);
    }
}
