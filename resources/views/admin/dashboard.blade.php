@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-gray-900 font-medium">Regular Users</h3>
                <div class="bg-purple-100 p-2 rounded-full">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-4">{{ $regularUsers }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-gray-900 font-medium">Total Notes</h3>
                <div class="bg-purple-100 p-2 rounded-full">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-4">{{ $totalNotes }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-gray-900 font-medium">Admin Users</h3>
                <div class="bg-purple-100 p-2 rounded-full">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-4">{{ $adminUsers }}</p>
        </div>
    </div>

    <!-- Recent Notes -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-900">Recent Notes</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">Created</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentNotes as $note)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $note->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $note->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $note->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.notes.show', $note) }}" 
                               class="text-purple-600 hover:text-purple-900">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Note Modal -->
<div id="noteModal" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-gray-600 bg-opacity-50 backdrop-blur-sm"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 id="noteTitle" class="text-xl font-bold text-gray-900"></h3>
                    <button onclick="closeNoteModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p id="noteContent" class="text-gray-600 whitespace-pre-wrap"></p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function viewNote(noteId) {
    // Show loading state
    document.getElementById('noteTitle').textContent = 'Loading...';
    document.getElementById('noteContent').textContent = '';
    document.getElementById('noteModal').classList.remove('hidden');

    fetch(`/api/notes/${noteId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('noteTitle').textContent = data.note.title;
        document.getElementById('noteContent').textContent = data.note.content;
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('noteTitle').textContent = 'Error';
        document.getElementById('noteContent').textContent = 'Failed to load note. Please try again.';
    });
}

function closeNoteModal() {
    document.getElementById('noteModal').classList.add('hidden');
}
</script>
@endsection 