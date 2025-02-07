@extends('layouts.dashboard')

@section('title', 'User Management')

@section('content')
<div class="max-w-7xl mx-auto">
    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex justify-between items-center">
        @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New User
            </a>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3 border-b">Name</th>
                        <th class="px-6 py-3 border-b">Email</th>
                        <th class="px-6 py-3 border-b">Role</th>
                        <th class="px-6 py-3 border-b">Notes</th>
                        <th class="px-6 py-3 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->notes->count() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                @if(auth()->user()->isSuperAdmin())
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="text-purple-600 hover:text-purple-900">Edit</a>
                                    <button onclick="confirmDelete({{ $user->id }})" class="text-red-600 hover:text-red-900">
                                      Delete
                                    </button>
                                @endif
                                <a href="{{ route('admin.users.notes', $user) }}" 
                                   class="text-purple-600 hover:text-purple-900">
                                    View Notes ({{ $user->notes->count() }})
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-gray-600 bg-opacity-50 backdrop-blur-sm"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4 relative">
            <div class="p-6">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Delete User</h3>
                    <p class="text-gray-500 mb-6">Are you sure you want to delete this user? All their notes will also be deleted. This action cannot be undone.</p>
                </div>
                <form id="deleteForm" method="POST" class="flex justify-end space-x-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeDeleteModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 border border-transparent rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Notes Modal -->
<div id="notesModal" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-gray-600 bg-opacity-50 backdrop-blur-sm"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">User Notes</h3>
                <div id="userNotesList" class="space-y-4 max-h-96 overflow-y-auto"></div>
                <div class="mt-6 flex justify-end">
                    <button onclick="closeNotesModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(userId) {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteForm').action = `/admin/users/${userId}`;
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function viewNotes(userId) {
    const notesList = document.getElementById('userNotesList');
    notesList.innerHTML = '<div class="flex justify-center py-4"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div></div>';
    document.getElementById('notesModal').classList.remove('hidden');

    fetch(`/api/users/${userId}/notes`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.notes.length === 0) {
            notesList.innerHTML = '<p class="text-gray-500 text-center py-4">No notes found</p>';
        } else {
            notesList.innerHTML = data.notes.map(note => `
                <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors duration-150">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">
                            <a href="/admin/notes/${note.id}" class="hover:text-purple-600">
                                ${note.title}
                            </a>
                        </h4>
                        <span class="text-xs text-gray-500">${note.created_at}</span>
                    </div>
                    <p class="text-gray-600 line-clamp-2">${note.content}</p>
                    <div class="mt-3">
                        <a href="/admin/notes/${note.id}" 
                           class="text-sm text-purple-600 hover:text-purple-900">
                            View Details →
                        </a>
                    </div>
                </div>
            `).join('');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        notesList.innerHTML = '<p class="text-red-500 text-center py-4">Failed to load notes. Please try again.</p>';
    });
}

function closeNotesModal() {
    document.getElementById('notesModal').classList.add('hidden');
}
</script>

@endsection