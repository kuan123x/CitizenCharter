@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Notifications</h1>

    <div>
        You have {{ auth()->user()->unreadNotifications()->count() }} unread notifications.
    </div>

    @if($notifications->isEmpty())
        <div class="bg-white p-4 rounded shadow">
            <p>No notifications available.</p>
        </div>
    @else
        @foreach($notifications as $notification)
            <div class="bg-white p-4 mb-4 rounded shadow">
                <h2 class="font-semibold">{{ $notification->title }}</h2>
                <p>{{ $notification->description }}</p>
                <p class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                <!-- Mark as read button -->
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="text-sm text-blue-500">Mark as Read</button>
                </form>
            </div>
        @endforeach
    @endif
@endsection
