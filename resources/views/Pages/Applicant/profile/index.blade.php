@extends('components.layout.applicant-layout')

@section('applicant-content')
<div class="min-h-screen">
    <header class="mt-2 sm:mt-4">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold leading-tight text-gray-900 tracking-tight">
          Profile Settings
        </h1>
      </div>
    </header>
    
    <main class="py-4 sm:py-6 lg:py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-4 sm:py-6">
          <div class="grid grid-cols-1 gap-6 lg:grid-cols-4 lg:gap-8">
            <!-- Sidebar Navigation - Sticky on larger screens -->
            <div class="lg:col-span-1">
              <div class="bg-white shadow overflow-hidden sm:rounded-lg sticky top-4">
                <div class="px-4 py-4 sm:px-6">
                  <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">
                    Settings Menu
                  </h3>
                </div>
                <div class="border-t border-gray-200">
                  <nav class="py-2">
                    <a href="?tab=account-settings" class="flex items-center px-4 py-2 sm:py-3 hover:bg-gray-50
                      @if($tab === 'account-settings') text-blue-600 @else text-gray-700 @endif
                      font-medium">
                      <i class="fas fa-user mr-2 w-5 text-center"></i> 
                      <span>Account Settings</span>
                    </a>
                    <a href="?tab=change-pass" class="flex items-center px-4 py-2 sm:py-3 hover:bg-gray-50 
                      @if($tab === 'change-pass') text-blue-600 @else text-gray-700 @endif">
                      <i class="fas fa-shield-alt mr-2 w-5 text-center"></i> 
                      <span>Change Password</span>
                    </a>
                  </nav>
                </div>
              </div>
              
              <!-- Mobile Navigation (visible only on small screens) -->
              <div class="fixed inset-x-0 bottom-0 bg-white shadow-lg border-t border-gray-200 flex lg:hidden z-10">
                <a href="?tab=account-settings" class="flex flex-1 flex-col items-center py-2 px-2
                  @if($tab === 'account-settings') text-blue-600 @else text-gray-700 @endif">
                  <i class="fas fa-user text-lg"></i>
                  <span class="text-xs mt-1">Account</span>
                </a>
                <a href="?tab=change-pass" class="flex flex-1 flex-col items-center py-2 px-2
                  @if($tab === 'change-pass') text-blue-600 @else text-gray-700 @endif">
                  <i class="fas fa-shield-alt text-lg"></i>
                  <span class="text-xs mt-1">Password</span>
                </a>
              </div>
            </div>
            
            <!-- Modal Overlay -->
            @include('Pages.Applicant.profile.upload-pic')
            
            <!-- Main Content -->
            <div class="lg:col-span-3 pb-16 lg:pb-0"> <!-- Added padding bottom for mobile navigation -->
              <!-- Profile Photo -->
              @if (isset($tab) && $tab == 'account-settings')
              <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                  <div class="flex flex-col sm:flex-row items-center">
                    <div class="mb-4 sm:mb-0 sm:mr-6 flex-shrink-0">
                      <img class="h-20 w-20 sm:h-24 sm:w-24 rounded-full object-cover"
                        src="@if($user_profile->profile_image){{asset('storage/profile_images/'.$user_profile->profile_image)}}@else{{asset('./assets/images/user-default.avif')}}@endif"
                        alt="Profile photo">
                    </div>
                    <div class="text-center sm:text-left">
                      <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Your Profile Photo</h3>
                      <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Clear photo helps people recognize you
                      </p>
                      <div class="mt-3">
                        <button type="button" id="openUploadModal"
                          class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                          <i class="fas fa-upload mr-2"></i> Upload new photo
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endif
              
              <!-- Personal Information Section -->
              @include('Pages.Applicant.profile.'.$tab)
            </div>
          </div>
        </div>
      </div>
    </main>
</div>

@push('scripts')
    <script src="{{asset('./assets/js/features/edit-profile.js')}}" type="module"></script>
@endpush
@endsection
