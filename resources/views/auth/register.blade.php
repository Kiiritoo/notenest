@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-2xl">
        <div class="text-center">
            <div class="flex justify-center">
                <div class="bg-purple-600 p-2 rounded-full inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">NoteNest</h2>
            <p class="mt-2 text-sm text-gray-600">Create your account</p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST" novalidate>
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" name="name" type="text" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 @error('name') border-red-500 @enderror"
                    value="{{ old('name') }}"
                    minlength="2">
                @include('partials.form-error', ['field' => 'name'])
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}"
                    minlength="5">
                @include('partials.form-error', ['field' => 'email'])
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 @error('password') border-red-500 @enderror"
                    minlength="8">
                @include('partials.form-error', ['field' => 'password'])
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                    minlength="8">
            </div>

            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Register
            </button>
        </form>
        <div class="text-center">
            <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-500">
                Already have an account? Login
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const emailInput = document.getElementById('email');
    let currentErrorMessage = null;
    
    emailInput.addEventListener('input', function() {
        // Hapus pesan error yang ada
        if (currentErrorMessage) {
            currentErrorMessage.remove();
        }

        if (this.value.length < 5) {
            this.classList.add('border-red-500');
            // Buat pesan error baru
            currentErrorMessage = document.createElement('p');
            currentErrorMessage.className = 'mt-1 text-sm text-red-600';
            currentErrorMessage.textContent = 'Email must be at least 5 characters long';
            this.parentElement.appendChild(currentErrorMessage);
        } else {
            this.classList.remove('border-red-500');
            currentErrorMessage = null;
        }
    });

    form.addEventListener('submit', function(e) {
        if (emailInput.value.length < 5) {
            e.preventDefault();
        }
    });
});
</script>
@endsection