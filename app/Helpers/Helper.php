<?php
use App\Models\User;
use App\Models\Option;
use App\Notifications\SendNotification;

function cache_remember(string $key, callable $callback, int $ttl = 1800): mixed {
    return cache()->remember($key, env('CACHE_LIFETIME', $ttl), $callback);
}

function get_option($key) {
    return cache_remember($key, function () use ($key) {
        return Option::where('key', $key)->first()->value ?? [];
    });
}

function formatted_date(string $date = null, string $format = 'd M, Y'): ?string
{
    return !empty($date) ? Date::parse($date)->format($format) : null;
}

function sendNotification($id, $url, $message, $user = null) {
    $notify = [
        'id' => $id,
        'url' => $url,
        'user' => $user,
        'message' => $message,
    ];

    $notify_user = User::where('role', 'superadmin')->first();
    Notification::send($notify_user, new SendNotification($notify));
}