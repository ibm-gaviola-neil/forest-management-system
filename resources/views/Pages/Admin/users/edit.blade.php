@extends('components.layout.dashboard-layout')

@section('content')

<div id="personal-info" class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            <i class="fas fa-user mr-2 text-indigo-500"></i> Personal Information
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Update your personal details
        </p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
        <form id="profileEditForm">
            <input type="hidden" value="{{$user_profile->id}}" id="user-id">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="first-name"
                        class="block text-sm font-medium text-gray-700">First name</label>
                    <input type="text" name="first_name" id="first-name"
                        value="{{$user_profile->first_name}}"
                        class="w-full p-2 border border-gray-300 rounded">
                    <span id="first_name_Error" class="error italic"></span>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="last-name" class="block text-sm font-medium text-gray-700">Last
                        name</label>
                    <input type="text" name="last_name" id="last-name" 
                        value="{{$user_profile->last_name}}"
                        class="w-full p-2 border border-gray-300 rounded">
                    <span id="last_name_Error" class="error italic"></span>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="last-name" class="block text-sm font-medium text-gray-700">Middle
                        name</label>
                    <input type="text" name="middle_name" id="middle_name" 
                        value="{{$user_profile->middle_name}}"    
                        class="w-full p-2 border border-gray-300 rounded">
                    <span id="middle_name_Error" class="error italic"></span>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="first-name"
                        class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" 
                        value="{{$user_profile->email}}"    
                        class="w-full p-2 border border-gray-300 rounded">
                    <span id="email_Error" class="error italic"></span>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="contact_number" id="contact_number" 
                        value="{{$user_profile->contact_number}}"  
                        class="w-full p-2 border border-gray-300 rounded">
                    <span id="contact_number_Error" class="error italic"></span>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Birthdate</label>
                    <input type="date" type="date" name="birth_date" id="birth_date" 
                        value="{{$user_profile->birth_date}}"  
                        class="w-full p-2 border border-gray-300 rounded">
                    <span id="birth_date_Error" class="error italic"></span>
                </div>

                <div class="col-span-6 sm:col-span-6">
                    <label for="address"
                        class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" 
                        value="{{$user_profile->address}}"  
                        class="w-full p-2 border border-gray-300 rounded">
                    <span id="address_Error" class="error italic"></span>
                </div>

                <div class="col-span-6 sm:col-span-6">
                    <label for="username"
                        class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username" 
                        value="{{$user_profile->username}}"  
                        class="w-full p-2 border border-gray-300 rounded">
                    <span id="username_Error" class="error italic"></span>
                </div>

            </div>
            <div id="loginResponse" class="mt-2"></div>
            <div class="mt-6">
                <a href="/admin/users/view/{{$user_profile->id}}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Profile
                </a>
                <button type="submit" id="submit-btn"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script src="{{asset('./assets/js/features/admin/users.js')}}" type="module"></script>
@endpush
@endsection