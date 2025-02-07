@extends('layouts.dashboard')

@section('title', 'Admin Panel')

@section('content')
<div class="max-w-7xl mx-auto">
    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-gray-900 font-medium">Total Users</h3>
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
                            <a href="{{ route('admin.notes.show', $note->id) }}" 
                               class="text-purple-600 hover:text-purple-900">
                                View Details
                            </a>
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
                <h3 id="noteTitle" class="text-xl font-bold text-gray-900 mb-4"></h3>
                <p id="noteContent" class="text-gray-600"></p>
                <div class="mt-6 flex justify-end">
                    <button onclick="closeNoteModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function viewNote(noteId) {
    fetch(`/api/notes/${noteId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('noteTitle').textContent = data.note.title;
            document.getElementById('noteContent').textContent = data.note.content;
            document.getElementById('noteModal').classList.remove('hidden');
        });
}

function closeNoteModal() {
    document.getElementById('noteModal').classList.add('hidden');
}
</script>
@endsection 