@extends('layouts.dashboard')

@section('title', 'Note Detail')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ url()->previous() }}" 
           class="inline-flex items-center text-sm text-purple-600 hover:text-purple-900">
            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="mb-6">
            <div class="flex justify-between items-start">
                <h1 class="text-2xl font-bold text-gray-900">{{ $note->title }}</h1>
                <div class="text-sm text-gray-500">
                    Created {{ $note->created_at->format('M d, Y H:i') }}
                </div>
            </div>
            <div class="mt-2 text-sm text-gray-600">
                By: {{ $note->user->name }}
            </div>
        </div>

        <div class="prose max-w-none">
            <p class="text-gray-600 whitespace-pre-wrap">{{ $note->content }}</p>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Note Information</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Author</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $note->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $note->user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $note->created_at->format('M d, Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $note->updated_at->format('M d, Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection 