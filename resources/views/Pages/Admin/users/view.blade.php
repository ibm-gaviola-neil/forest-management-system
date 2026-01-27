@extends('components.layout.dashboard-layout')

@section('content')
<div class="container mx-auto px-4 py-8">
  <!-- Profile Header with Image -->
  <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
      <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
          <div>
              <h1 class="text-2xl font-bold text-gray-900">User Profile</h1>
              <p class="mt-1 text-sm text-gray-500">User profile information</p>
          </div>
          <div class="flex items-center">
              <div class="h-24 w-24 rounded-full overflow-hidden">
                  @if($user_profile->profile_image)
                  <img class="h-20 w-20 sm:h-24 sm:w-24 rounded-full object-cover"
                  src="@if($user_profile->profile_image){{asset('storage/profile_images/'.$user_profile->profile_image)}}@else{{asset('./assets/images/user-default.avif')}}@endif"
                  alt="Profile photo">
                  @else
                      <div class="h-full w-full flex items-center justify-center bg-indigo-50 text-indigo-500">
                          <i class="fas fa-user text-4xl"></i>
                      </div>
                  @endif
              </div>
              <div class="ml-4">
                  <h2 class="text-xl font-semibold">{{ $user_profile->first_name }} {{ $user_profile->last_name }}</h2>
                  <p class="text-gray-500">{{ $user_profile->email }}</p>
                  <p class="text-sm text-gray-400">Member since: {{ \Carbon\Carbon::parse($user_profile->created_at)->format('M d, Y') }}</p>
              </div>
          </div>
      </div>
  </div>

  <!-- Personal Information Section -->
  <div id="personal-info" class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
      <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">
              <i class="fas fa-user mr-2 text-indigo-500"></i> Personal Information
          </h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">
              Applicant personal details
          </p>
      </div>
      <div class="border-t border-gray-200">
          <dl>
              <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Full name</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                      {{ $user_profile->first_name }} {{ $user_profile->middle_name }} {{ $user_profile->last_name }}
                  </dd>
              </div>
              <div class="bg-white px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Email address</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user_profile->email }}</dd>
              </div>
              <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Username</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user_profile->username }}</dd>
              </div>
              <div class="bg-white px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Phone number</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user_profile->contact_number }}</dd>
              </div>
              <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Birth date</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                      {{ $user_profile->birth_date ? \Carbon\Carbon::parse($user_profile->birth_date)->format('F d, Y') : 'Not provided' }}
                  </dd>
              </div>
              <div class="bg-white px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Address</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                      {{ $user_profile->address ?: 'Not provided' }}
                  </dd>
              </div>
          </dl>
      </div>
  </div>

  <!-- Action Buttons -->
  <div class="flex justify-end space-x-4 mt-6">
      <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <i class="fas fa-arrow-left mr-2"></i> Back to Applicants
      </a>
      @if(auth()->user()->role === 'general_admin')
          {{-- <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <i class="fas fa-edit mr-2"></i> Edit Profile
          </a> --}}
          <a href="{{ route('admin.users.edit', $user_profile->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <i class="fas fa-edit mr-2"></i> Edit Profile
          </a>
      @endif
  </div>
</div>

{{-- @include('Pages.Admin.trees.reject-modal')
@include('Pages.Admin.trees.approve-modal') --}}
@push('scripts')
  <script src="{{asset('./assets/js/features/admin/admin-tree.js')}}" type="module"></script>
  <script src="{{ asset('./assets/js/domain/map-view.js') }}"></script>
@endpush
@endsection