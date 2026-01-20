@extends('components.layout.applicant-layout')
@section('applicant-content')
<!-- Settings Header with improved responsive styling -->
<div class="mb-4 sm:mb-6 border-b border-gray-200 pb-3 sm:pb-4 sm:mt-2">
  <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-1 sm:mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
    Settings
  </h2>
  <p class="text-xs sm:text-sm text-gray-500 mt-1">Manage your account preferences and security</p>
</div>

<!-- Settings Options with improved responsive cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
  <!-- Account Information Card -->
  <a href="/applicant/profile" class="group relative overflow-hidden bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex flex-col p-3 sm:p-4 md:p-5 border border-gray-100">
    <div class="absolute top-0 right-0 w-12 h-12 sm:w-16 sm:h-16 bg-green-50 rounded-bl-full group-hover:bg-green-100 transition-colors duration-300"></div>
    
    <div class="flex items-center mb-2 sm:mb-3 md:mb-4">
      <div class="flex-shrink-0 p-2 sm:p-3 bg-green-50 rounded-full group-hover:bg-green-100 transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
      </div>
    </div>
    
    <h4 class="font-semibold text-gray-800 text-base sm:text-lg group-hover:text-green-700 transition-colors duration-300">Account Information</h4>
    <p class="text-xs sm:text-sm text-gray-600 mt-1">Update your profile details, contact information, and preferences</p>
    
    <div class="mt-auto pt-2 sm:pt-3 md:pt-4 flex items-center text-green-600 text-xs sm:text-sm font-medium">
      <span>View details</span>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </div>
  </a>

  <!-- Change Password Card -->
  <a href="/applicant/profile?tab=change-pass" class="group relative overflow-hidden bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex flex-col p-3 sm:p-4 md:p-5 border border-gray-100">
    <div class="absolute top-0 right-0 w-12 h-12 sm:w-16 sm:h-16 bg-yellow-50 rounded-bl-full group-hover:bg-yellow-100 transition-colors duration-300"></div>
    
    <div class="flex items-center mb-2 sm:mb-3 md:mb-4">
      <div class="flex-shrink-0 p-2 sm:p-3 bg-yellow-50 rounded-full group-hover:bg-yellow-100 transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
        </svg>
      </div>
    </div>
    
    <h4 class="font-semibold text-gray-800 text-base sm:text-lg group-hover:text-yellow-700 transition-colors duration-300">Change Password</h4>
    <p class="text-xs sm:text-sm text-gray-600 mt-1">Update your password to keep your account secure</p>
    
    <div class="mt-auto pt-2 sm:pt-3 md:pt-4 flex items-center text-yellow-600 text-xs sm:text-sm font-medium">
      <span>Update password</span>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </div>
  </a>

  <!-- Logout Card -->
  <form action="/logout" method="POST" class="sm:col-span-2 lg:col-span-1 group h-full">
    @csrf
    <button type="submit" class="w-full h-full text-left group relative overflow-hidden bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex flex-col p-3 sm:p-4 md:p-5 border border-gray-100">
      <div class="absolute top-0 right-0 w-12 h-12 sm:w-16 sm:h-16 bg-red-50 rounded-bl-full group-hover:bg-red-100 transition-colors duration-300"></div>
      
      <div class="flex items-center mb-2 sm:mb-3 md:mb-4">
        <div class="flex-shrink-0 p-2 sm:p-3 bg-red-50 rounded-full group-hover:bg-red-100 transition-colors duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
        </div>
      </div>
      
      <h4 class="font-semibold text-gray-800 text-base sm:text-lg group-hover:text-red-700 transition-colors duration-300">Logout</h4>
      <p class="text-xs sm:text-sm text-gray-600 mt-1">Sign out securely from your account</p>
      
      <div class="mt-auto pt-2 sm:pt-3 md:pt-4 flex items-center text-red-600 text-xs sm:text-sm font-medium">
        <span>Sign out</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </div>
    </button>
  </form>
</div>
@endsection