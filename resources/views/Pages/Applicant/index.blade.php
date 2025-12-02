@extends('components.layout.applicant-layout')

@section('applicant-content')
    <h1 id="userWelcome" class="text-4xl font-bold mb-3"></h1>
    <p class="text-gray-700 text-xl mb-10">What would you like to do today?</p>

    <!-- Box Grid with Larger Boxes and 3-inch Spacing -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 max-w-full sm:max-w-4xl md:max-w-5xl mx-auto">
    <!-- Box 1: Register a Tree -->
    <a href="tree-registration.html" class="bg-green-500 hover:bg-green-600 text-white p-10 rounded-2xl shadow-lg flex items-center justify-between text-2xl h-56">
        <div>
        <h2 class="font-bold mb-2">Register a Tree</h2>
        <p class="text-lg">Record new trees</p>
        </div>
        <img src="{{asset('./assets/images/tree.png')}}" alt="Tree Registration" class="w-12 h-12"/>
    </a>

    <!-- Box 2: Chainsaw Registration -->
    <a href="chainsaw-registration.html" class="bg-blue-400 hover:bg-blue-500 text-white p-10 rounded-2xl shadow-lg flex items-center justify-between text-2xl h-56">
        <div>
        <h2 class="font-bold mb-2">Chainsaw Registration</h2>
        <p class="text-lg">Add a chainsaw</p>
        </div>
        <img src="{{asset('./assets/images/Chainsaw.png')}}" alt="Chainsaw Registration" class="w-12 h-12"/>
    </a>

    <!-- Box 3: Tree Cutting Permit -->
    <a href="tree-cutting-permit.html" class="bg-red-400 hover:bg-red-500 text-white p-10 rounded-2xl shadow-lg flex items-center justify-between text-2xl h-56">
        <div>
        <h2 class="font-bold mb-2">Apply for Tree Cutting Permit</h2>
        <p class="text-lg">Request a permit for cutting trees</p>
        </div>
        <img src="{{asset('./assets/images/cutting.png')}}" alt="Tree Cutting Permit" class="w-12 h-12"/>
    </a>

    <!-- Box 4: Upload Requirements -->
    <a href="upload-requirements.html" class="bg-gray-300 hover:bg-gray-400 text-white p-10 rounded-2xl shadow-lg flex items-center justify-between text-2xl h-56">
        <div>
        <h2 class="font-bold mb-2">Upload Requirements</h2>
        <p class="text-lg">Submit documents</p>
        </div>
        <img src="{{asset('./assets/images/requirements.png')}}" alt="Upload Requirements" class="w-12 h-12"/>
    </a>

    <!-- Box 5: View Permits -->
    <a href="permit-status.html" class="bg-orange-300 hover:bg-orange-400 text-white p-10 rounded-2xl shadow-lg flex items-center justify-between text-2xl h-56">
        <div>
        <h2 class="font-bold mb-2">View Permits</h2>
        <p class="text-lg">Check your permit status</p>
        </div>
        <img src="{{asset('./assets/images/permit.png')}}" alt="Permit Status" class="w-12 h-12"/>
    </a>
    </div>
@endsection  
    
