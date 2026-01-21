@extends('components.layout.applicant-layout')
@section('applicant-content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <div class="text-center sm:text-left mb-8 sm:mb-12">
    <h1 id="userWelcome" class="text-2xl sm:text-3xl md:text-4xl font-bold mb-2 sm:mb-3 text-gray-800 transition-opacity animate-fade-in"></h1>
    <p class="text-gray-600 text-base sm:text-lg md:text-xl">What would you like to do today?</p>
  </div>

  <!-- Box Grid with improved responsiveness and visual enhancements -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 md:gap-10">
    <!-- Box 1: Register a Tree -->
    <a href="/applicant/treeRegistration" class="group relative overflow-hidden bg-green-500 hover:bg-green-600 transition-all duration-300 text-white rounded-2xl shadow-lg flex flex-col h-auto sm:h-56">
      <div class="absolute top-0 right-0 w-32 h-32 bg-green-400 rounded-full opacity-20 -mr-10 -mt-10"></div>
      <div class="absolute bottom-0 left-0 w-24 h-24 bg-green-400 rounded-full opacity-20 -ml-10 -mb-10"></div>
      
      <div class="p-6 sm:p-8 flex flex-col h-full relative z-10">
        <div class="flex justify-between items-start mb-auto">
          <div>
            <h2 class="font-bold text-xl sm:text-2xl mb-2">Register a Tree</h2>
            <p class="text-green-100 text-sm sm:text-base">Record new trees in the system</p>
          </div>
          <div class="bg-white bg-opacity-20 p-3 rounded-lg transform group-hover:rotate-3 transition-transform duration-300">
            <img src="{{asset('./assets/images/tree.png')}}" alt="Tree Registration" class="w-8 h-8 sm:w-10 sm:h-10"/>
          </div>
        </div>
        
        <div class="mt-4 flex items-center text-sm text-green-100 group-hover:text-white">
          <span class="font-medium">Get started</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </div>
      </div>
    </a>

    <!-- Box 2: Chainsaw Registration -->
    <a href="/applicant/chainsaw" class="group relative overflow-hidden bg-blue-400 hover:bg-blue-500 transition-all duration-300 text-white rounded-2xl shadow-lg flex flex-col h-auto sm:h-56">
      <div class="absolute top-0 right-0 w-32 h-32 bg-blue-300 rounded-full opacity-20 -mr-10 -mt-10"></div>
      <div class="absolute bottom-0 left-0 w-24 h-24 bg-blue-300 rounded-full opacity-20 -ml-10 -mb-10"></div>
      
      <div class="p-6 sm:p-8 flex flex-col h-full relative z-10">
        <div class="flex justify-between items-start mb-auto">
          <div>
            <h2 class="font-bold text-xl sm:text-2xl mb-2">Chainsaw Registration</h2>
            <p class="text-blue-100 text-sm sm:text-base">Register your chainsaw equipment</p>
          </div>
          <div class="bg-white bg-opacity-20 p-3 rounded-lg transform group-hover:rotate-3 transition-transform duration-300">
            <img src="{{asset('./assets/images/Chainsaw.png')}}" alt="Chainsaw Registration" class="w-8 h-8 sm:w-10 sm:h-10"/>
          </div>
        </div>
        
        <div class="mt-4 flex items-center text-sm text-blue-100 group-hover:text-white">
          <span class="font-medium">Register now</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </div>
      </div>
    </a>

    <!-- Box 3: Tree Cutting Permit -->
    <a href="/applicant/cutting" class="group relative overflow-hidden bg-red-400 hover:bg-red-500 transition-all duration-300 text-white rounded-2xl shadow-lg flex flex-col h-auto sm:h-56">
      <div class="absolute top-0 right-0 w-32 h-32 bg-red-300 rounded-full opacity-20 -mr-10 -mt-10"></div>
      <div class="absolute bottom-0 left-0 w-24 h-24 bg-red-300 rounded-full opacity-20 -ml-10 -mb-10"></div>
      
      <div class="p-6 sm:p-8 flex flex-col h-full relative z-10">
        <div class="flex justify-between items-start mb-auto">
          <div>
            <h2 class="font-bold text-xl sm:text-2xl mb-2">Apply for Tree Cutting</h2>
            <p class="text-red-100 text-sm sm:text-base">Request permission to cut trees</p>
          </div>
          <div class="bg-white bg-opacity-20 p-3 rounded-lg transform group-hover:rotate-3 transition-transform duration-300">
            <img src="{{asset('./assets/images/cutting.png')}}" alt="Tree Cutting Permit" class="w-8 h-8 sm:w-10 sm:h-10"/>
          </div>
        </div>
        
        <div class="mt-4 flex items-center text-sm text-red-100 group-hover:text-white">
          <span class="font-medium">Apply now</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </div>
      </div>
    </a>
  </div>

  <!-- JavaScript for welcome message -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const userWelcome = document.getElementById('userWelcome');
      const hours = new Date().getHours();
      let greeting = "Welcome";
      
      if (hours < 12) {
        greeting = "Good Morning";
      } else if (hours < 18) {
        greeting = "Good Afternoon";
      } else {
        greeting = "Good Evening";
      }
      
      // Get user name from session if available
      const userName = "{{ Auth::user()->name ?? 'User' }}";
      userWelcome.textContent = `${greeting}, ${userName}!`;
      userWelcome.classList.add('opacity-100');
    });
  </script>
</div>
@endsection

<style>
  @keyframes fadeIn {
    0% { opacity: 0; transform: translateY(10px); }
    100% { opacity: 1; transform: translateY(0); }
  }
  
  .animate-fade-in {
    animation: fadeIn 0.8s ease-out forwards;
  }
</style>