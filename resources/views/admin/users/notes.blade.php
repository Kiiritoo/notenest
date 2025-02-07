@extends('layouts.dashboard')

@section('title', 'User Notes')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.users') }}" 
           class="inline-flex items-center text-sm text-purple-600 hover:text-purple-900">
            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Users
        </a>
    </div>

    <h1 class="text-2xl font-bold text-gray-900 mb-6">Notes by {{ $user->name }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($notes as $note)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-bold text-gray-900">{{ $note->title }}</h2>
                    <span class="text-sm text-gray-500">{{ $note->created_at->format('M d, Y') }}</span>
                </div>
                <p class="text-gray-600 mb-4">{{ $note->content }}</p>
                <div class="mt-4">
                    <a href="{{ route('admin.notes.show', $note) }}" 
                       class="text-purple-600 hover:text-purple-900">
                        View Details →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-gray-500">
                No notes found for this user.
            </div>
        @endforelse
    </div>
</div>
@endsection 