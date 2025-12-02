<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sign Up - Forest Monitoring System</title>
  <script src="https://cdn.tailwindcss.com"></script>

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
</head>
<body class="bg-green-50 font-sans text-gray-900">

  <div class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-lg p-10">
        <div class="flex items-center justify-center mb-6">
            <img src="{{asset('./assets/images/logo.jpg')}}" alt="Logo" class="w-14 h-14 mr-3 rounded-full border-2 border-white shadow-md">
            <h1 class="text-sm font-bold leading-tight">
                WEB-BASED FOREST MONITORING<br>AND PERMITTING SYSTEM
            </h1>
        </div>
      <h2 class="text-3xl font-bold text-center mb-6 text-green-800 uppercase">Create Your Account</h2>
      <form id="add-donor-form" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">First Name</label>
            <input type="text" name="first_name" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
            <span id="first_name_Error" class="error italic"></span>
          </div>
          <div>
            <label class="block font-medium mb-1">Middle Name</label>
            <input type="text" name="middle_name" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
            <span id="middle_name_Error" class="error italic"></span>
          </div>
          <div>
            <label class="block font-medium mb-1">Last Name</label>
            <input type="text" name="last_name" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
            <span id="last_name_Error" class="error italic"></span>
          </div>
          <div>
            <label class="block font-medium mb-1">Birthdate</label>
            <input type="date" name="birth_date" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
            <span id="birth_date_Error" class="error italic"></span>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
            <span id="email_Error" class="error italic"></span>
          </div>
          <div>
            <label class="block font-medium mb-1">Confirm Email</label>
            <input type="email" name="confirmEmail" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
            <span id="confirmEmail_Error" class="error italic"></span>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
            <span id="password_Error" class="error italic"></span>
          </div>
          <div>
            <label class="block font-medium mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
            <span id="password_confirmation_Error" class="error italic"></span>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Phone Number</label>
            <input type="text" name="contact_number" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
            <span id="contact_number_Error" class="error italic"></span>
          </div>
          <div>
            <label class="block font-medium mb-1">Address</label>
            <input type="text" name="address" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
            <span id="address_Error" class="error italic"></span>
          </div>
        </div>

        <button type="submit" id="submit-btn" class="w-full mt-6 bg-green-700 text-white font-semibold py-3 rounded-lg hover:bg-green-800 transition">
          Sign Up
        </button>
      </form>

      <p class="text-center mt-6 text-sm">
        Already have an account?
        <a href="/" class="text-green-700 font-semibold hover:underline">Log In</a>
      </p>
    </div>
  </div>

  <script src="{{asset('./assets/js/register.js')}}" type="module"></script>

</body>
</html>
