@extends('components.layout.applicant-layout')

@section('applicant-content')
    <div>
        <header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">
                    Profile Settings
                </h1>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="px-4 py-8 sm:px-0">

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4 lg:gap-8">

                        <!-- Sidebar Navigation -->
                        <div class="lg:col-span-1">
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                <div class="px-4 py-5 sm:px-6">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Settings Menu
                                    </h3>
                                </div>
                                <div class="border-t border-gray-200">
                                    <nav class="py-2">
                                        <a href="#personal-info" class="block px-4 py-3 hover:bg-gray-50 text-blue-600 font-medium">
                                            <i class="fas fa-user mr-2"></i> Account Settings
                                        </a>
                                        <a href="#account" class="block px-4 py-3 hover:bg-gray-50 text-gray-700">
                                            <i class="fas fa-shield-alt mr-2"></i> Change Password
                                        </a>
                                    </nav>
                                </div>
                            </div>
                        </div>


                        <!-- Main Content -->
                        <div class="lg:col-span-3">
                            <!-- Profile Photo -->
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                                <div class="px-4 py-5 sm:p-6">
                                    <div class="flex flex-col sm:flex-row items-center">
                                        <div class="mb-4 sm:mb-0 sm:mr-6 flex-shrink-0">
                                            <img class="h-24 w-24 rounded-full object-cover"
                                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                alt="Profile photo">
                                        </div>
                                        <div class="text-center sm:text-left">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">Your Profile Photo</h3>
                                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                                Clear photo helps people recognize you
                                            </p>
                                            <div class="mt-3 flex flex-col sm:flex-row">
                                                <button type="button"
                                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <i class="fas fa-upload mr-2"></i> Upload new photo
                                                </button>
                                                <button type="button"
                                                    class="mt-3 sm:mt-0 sm:ml-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Remove photo
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Information Section -->
                            @include('Pages.Applicant.profile.account-settings')
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
