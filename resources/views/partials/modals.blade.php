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