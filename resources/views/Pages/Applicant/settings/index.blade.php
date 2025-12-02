@extends('components.layout.applicant-layout')

@section('applicant-content')
  <!-- Settings Header -->
  <h2 class="text-3xl font-bold mb-4">Settings</h2>

  <!-- Settings Options -->
  <div class="space-y-3">
    <a href="account-info.html" class="block bg-gray-50 p-4 rounded-lg flex items-center space-x-4 shadow hover:bg-gray-100">
      <div class="text-green-600 text-2xl">👤</div>
      <div>
        <h4 class="font-semibold">Account Information</h4>
        <p class="text-sm text-gray-600">Update your profile info</p>
      </div>
    </a>

    <a href="change-password.html" class="block bg-gray-50 p-4 rounded-lg flex items-center space-x-4 shadow hover:bg-gray-100">
      <div class="text-yellow-600 text-2xl">🔒</div>
      <div>
        <h4 class="font-semibold">Change Password</h4>
        <p class="text-sm text-gray-600">Update your password</p>
      </div>
    </a>

    <a href="privacy-settings.html" class="block bg-gray-50 p-4 rounded-lg flex items-center space-x-4 shadow hover:bg-gray-100">
      <div class="text-gray-700 text-2xl">⚙️</div>
      <div>
        <h4 class="font-semibold">Privacy Setting</h4>
        <p class="text-sm text-gray-600">Control your privacy preferences</p>
      </div>
    </a>

    <form action="/logout" method="POST">
        @csrf
        <button type="submit" class="w-full block bg-gray-50 p-4 rounded-lg flex items-center space-x-4 shadow hover:bg-gray-100">
          <div class="text-red-600 text-2xl">🚪</div>
          <div>
            <h4 class="font-semibold">Logout</h4>
            <p class="text-sm text-gray-600">Security sign out</p>
          </div>
        </button>
    </form>
  </div>
@endsection  
    
