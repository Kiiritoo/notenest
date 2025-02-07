@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit User</h2>
        
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 p-4">
                <div class="flex">
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

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" 
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password (leave blank to keep current)</label>
                <input type="password" name="new_password" id="new_password"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 border border-transparent rounded-lg text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 