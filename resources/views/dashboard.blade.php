@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Create Note Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 md:mb-6">Create New Note</h2>
        
        <!-- Validation Messages -->
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('notes.store') }}" method="POST" class="space-y-4" id="createNoteForm">
            @csrf
            <div class="space-y-4">
                <div>
                    <input type="text" 
                        name="title" 
                        id="title"
                        placeholder="Enter note title..." 
                        value="{{ old('title') }}"
                        class="w-full px-4 py-3 rounded-lg border @error('title') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <textarea 
                        name="content" 
                        id="content"
                        placeholder="Write your note content..." 
                        rows="4"
                        class="w-full px-4 py-3 rounded-lg border @error('content') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full sm:w-auto px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                    Create Note
                </button>
            </div>
        </form>
    </div>

    <!-- Notes Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        @foreach ($notes as $note)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition-all duration-150">
                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-3">{{ $note->title }}</h3>
                <p class="text-gray-600 mb-4">{{ $note->content }}</p>
                <div class="flex flex-wrap gap-2 justify-end">
                    <button onclick="editNote({{ $note->id }}, '{{ addslashes($note->title) }}', '{{ addslashes($note->content) }}')" 
                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </button>
                    <button onclick="confirmDelete({{ $note->id }})" 
                        class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

@include('partials.modals')
@endsection

@section('modals')
<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-gray-600 bg-opacity-50 backdrop-blur-sm"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 relative">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Edit Note</h3>
                <form id="editForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="editTitle" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="editTitle" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <div>
                        <label for="editContent" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea name="content" id="editContent" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-lg text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            Update Note
                        </button>
                    </div>
                </form>
            </div>
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
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Note</h3>
                    <p class="text-gray-500 mb-6">Are you sure you want to delete this note? This action cannot be undone.</p>
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
                        Delete Note
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editNote(id, title, content) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editForm').action = `/notes/${id}`;
    document.getElementById('editTitle').value = title.replace(/&quot;/g, '"');
    document.getElementById('editContent').value = content.replace(/&quot;/g, '"');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function confirmDelete(id) {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteForm').action = `/notes/${id}`;
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection