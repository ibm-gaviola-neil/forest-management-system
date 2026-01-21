<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Forest Monitoring System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>
  .error {
    color: red;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
  }

  .error-input {
    border-color: red !important;
  }
</style>

<body class="bg-green-50 font-sans text-gray-900">

<div class="min-h-screen flex items-center justify-center px-4">
  <div class="bg-white rounded-2xl shadow-lg flex max-w-5xl w-full">
    <div class="w-1/2 p-8 bg-green-200 hidden md:flex flex-col justify-start rounded-l-2xl">
      <div class="flex items-center mb-6">
        <img src="{{asset('./assets/images/logo.jpg')}}" alt="Logo" class="w-14 h-14 mr-3 rounded-full border-2 border-white shadow-md">
        <h1 class="text-sm font-bold leading-tight">
          WEB-BASED FOREST MONITORING<br>AND PERMITTING SYSTEM
        </h1>
      </div>
      <div class="flex justify-center items-center flex-grow">
        <img src="{{asset('./assets/images/log-in.png')}}" alt="Illustration" class="w-[3000px] h-auto max-w-full">
      </div>
    </div>

    <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
      <h2 class="text-2xl font-semibold mb-1">Welcome to</h2>
      <h1 class="text-3xl font-bold text-green-600 mb-6">Permitting System</h1>

      <div class="mb-4">
        <a href="/auth/google" class="w-full flex items-center justify-center gap-3 border border-gray-300 py-2 px-4 rounded-lg hover:bg-gray-100">
          <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" />
          <span class="text-sm font-medium text-gray-700">Login with Google</span>
        </a>
      </div>

      <div class="flex items-center my-4">
        <hr class="flex-grow border-gray-300">
        <span class="mx-2 text-sm text-gray-500">or</span>
        <hr class="flex-grow border-gray-300">
      </div>

      <form id="loginForm">
        <div class="mb-4">
          <label class="block text-sm font-medium">Email</label>
          <input type="email" name="email" id="loginEmail" class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-md focus:ring-green-500 focus:outline-none"  />
          <span id="email_Error" class="error italic"></span>
        </div>

        <div class="mb-4 relative">
          <label class="block text-sm font-medium">Password</label>
          <input type="password" name="password" id="loginPassword" class="w-full border border-gray-300 rounded-lg px-4 py-2 pr-10 shadow-md focus:ring-green-500 focus:outline-none"  />
          <span id="password_Error" class="error italic"></span>
          <button type="button" onclick="togglePassword()" class="absolute right-3 top-8 text-gray-500 text-sm"></button>
        </div>

        <div class="flex items-center justify-between mb-4 text-sm">
          <label class="flex items-center">
            <input type="checkbox" class="mr-2">
            Remember me
          </label>
          <a href="#" onclick="handleForgotPassword()" class="text-green-600 hover:underline">Forgot Password?</a>
        </div>

        <button id="login-btn" type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
          Log In
        </button>

        @if (session('error'))
          <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 mt-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-red-700">
                  {{ session('error') }}
                </p>
              </div>
            </div>
          </div>
        @endif
      </form>

      <p class="text-sm text-center mt-6">
        Don’t have an account?
        <a href="/register" class="text-green-600 font-semibold hover:underline">Register</a>
      </p>

      <div id="loginResponse" class="text-center mt-4 text-red-500 hidden">
        Invalid email or password!
      </div>
    </div>
  </div>
</div>

<script src="{{asset('/assets/js/features/login.js')}}" type="module"></script>

</body>
</html>
