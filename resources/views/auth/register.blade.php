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

        @if ($errors->has('email') && $errors->first('email') === 'The email has already been taken.')
            <div class="rounded-lg bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">This email is already registered.</p>
                    </div>
                </div>
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST" id="registerForm" novalidate>
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" name="name" type="text" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                    value="{{ old('name') }}"
                    minlength="2">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                    value="{{ old('email') }}">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                    minlength="8">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
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
    const form = document.getElementById('registerForm');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
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

    nameInput.addEventListener('input', function() {
        if (this.value.length < 2) {
            showError(this, 'Name must be at least 2 characters long');
        } else {
            removeError(this);
        }
    });

    emailInput.addEventListener('input', function() {
        if (!validateEmail(this.value)) {
            showError(this, 'Please enter a valid email address');
        } else {
            removeError(this);
        }
    });

    function validatePassword() {
        if (passwordInput.value.length < 8) {
            showError(passwordInput, 'Password must be at least 8 characters long');
            return false;
        }
        removeError(passwordInput);

        if (passwordConfirmInput.value && passwordInput.value !== passwordConfirmInput.value) {
            showError(passwordConfirmInput, 'Passwords do not match');
            return false;
        }
        removeError(passwordConfirmInput);
        return true;
    }

    passwordInput.addEventListener('input', validatePassword);
    passwordConfirmInput.addEventListener('input', validatePassword);

    form.addEventListener('submit', function(e) {
        let isValid = true;

        // Validate name
        if (nameInput.value.length < 2) {
            showError(nameInput, 'Name must be at least 2 characters long');
            isValid = false;
        }

        // Validate email
        if (!validateEmail(emailInput.value)) {
            showError(emailInput, 'Please enter a valid email address');
            isValid = false;
        }

        // Validate password
        if (!validatePassword()) {
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection