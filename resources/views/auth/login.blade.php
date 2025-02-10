@extends('layouts.app')

@section('title', 'Login')

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
            <p class="mt-2 text-sm text-gray-600">Sign in to access your notes</p>
        </div>

        @if ($errors->has('email') && $errors->first('email') === 'Email atau password yang anda masukkan salah.')
            <div class="rounded-lg bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">Invalid email or password.</p>
                    </div>
                </div>
            </div>
        @endif

        <form id="loginForm" class="mt-8 space-y-6" action="{{ route('login') }}" method="POST" novalidate>
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Sign in
            </button>
        </form>
        <div class="text-center space-y-2">
            <a href="#" class="font-medium text-purple-600 hover:text-purple-500 block">
                Forgot your password?
            </a>
            <a href="{{ route('register') }}" class="font-medium text-purple-600 hover:text-purple-500 block">
                Don't have an account? Register
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    let currentErrorMessages = {};

    function showError(input, message) {
        removeError(input);
        const errorElement = document.createElement('p');
        errorElement.className = 'mt-1 text-sm text-red-600';
        errorElement.textContent = message;
        input.classList.add('border-red-500');
        input.parentElement.appendChild(errorElement);
        currentErrorMessages[input.id] = errorElement;
    }

    function removeError(input) {
        if (currentErrorMessages[input.id]) {
            currentErrorMessages[input.id].remove();
            currentErrorMessages[input.id] = null;
            input.classList.remove('border-red-500');
        }
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    emailInput.addEventListener('input', function() {
        if (!this.value) {
            showError(this, 'Email is required');
        } else if (!validateEmail(this.value)) {
            showError(this, 'Please enter a valid email address');
        } else {
            removeError(this);
        }
    });

    passwordInput.addEventListener('input', function() {
        if (!this.value) {
            showError(this, 'Password is required');
        } else {
            removeError(this);
        }
    });

    form.addEventListener('submit', function(e) {
        let isValid = true;

        if (!emailInput.value) {
            showError(emailInput, 'Email is required');
            isValid = false;
        } else if (!validateEmail(emailInput.value)) {
            showError(emailInput, 'Please enter a valid email address');
            isValid = false;
        }

        if (!passwordInput.value) {
            showError(passwordInput, 'Password is required');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection