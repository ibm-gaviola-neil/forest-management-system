<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Registered Trees Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-emerald-600 transition-transform duration-300 hover:transform hover:scale-105">
      <div class="flex justify-between items-start">
        <div>
          <h2 class="text-gray-600 text-sm font-semibold uppercase tracking-wider mb-2">Registered Trees</h2>
          <p class="text-3xl font-bold text-gray-800" id="registeredTrees">{{$counts['trees']}}</p>
          <div class="text-xs text-gray-500 mt-2 flex items-center">
            <span class="inline-block mr-1"><i class="fas fa-tree"></i></span>
            Total documented species
          </div>
        </div>
        <div class="rounded-full bg-emerald-100 p-3">
          <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
      </div>
    </div>
    
    <!-- Registered Chainsaw Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-amber-600 transition-transform duration-300 hover:transform hover:scale-105">
      <div class="flex justify-between items-start">
        <div>
          <h2 class="text-gray-600 text-sm font-semibold uppercase tracking-wider mb-2">Registered Chainsaws</h2>
          <p class="text-3xl font-bold text-gray-800" id="registeredChainsaws">{{$counts['chainsaw']}}</p>
          <div class="text-xs text-gray-500 mt-2 flex items-center">
            <span class="inline-block mr-1"><i class="fas fa-cog"></i></span>
            Active equipment licenses
          </div>
        </div>
        <div class="rounded-full bg-amber-100 p-3">
          <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
        </div>
      </div>
    </div>
    
    <!-- Cutting Permit Applications Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-indigo-600 transition-transform duration-300 hover:transform hover:scale-105">
      <div class="flex justify-between items-start">
        <div>
          <h2 class="text-gray-600 text-sm font-semibold uppercase tracking-wider mb-2">Cutting Permit Applications</h2>
          <p class="text-3xl font-bold text-gray-800" id="cuttingPermits">{{$counts['permits']}}</p>
          <div class="text-xs text-gray-500 mt-2 flex items-center">
            <span class="inline-block mr-1"><i class="fas fa-file-alt"></i></span>
            Pending approval
          </div>
        </div>
        <div class="rounded-full bg-indigo-100 p-3">
          <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
      </div>
    </div>
    
    <!-- Reported Incidents Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-rose-600 transition-transform duration-300 hover:transform hover:scale-105">
      <div class="flex justify-between items-start">
        <div>
          <h2 class="text-gray-600 text-sm font-semibold uppercase tracking-wider mb-2">Reported Incidents</h2>
          <p class="text-3xl font-bold text-rose-700" id="reportedIncidents">{{$counts['incidents']}}</p>
          <div class="text-xs text-gray-500 mt-2 flex items-center">
            <span class="inline-block mr-1"><i class="fas fa-flag"></i></span>
            Total Reported Cases
          </div>
        </div>
        <div class="rounded-full bg-rose-100 p-3">
          <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
          </svg>
        </div>
      </div>
    </div>
  </div>