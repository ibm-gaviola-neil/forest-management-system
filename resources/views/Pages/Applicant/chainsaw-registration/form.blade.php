<div>
    <label class="block mb-1 font-medium">Serial Number</label>
    <input name="serial_number" type="text" class="w-full p-2 border border-gray-300 rounded"
        placeholder="Enter serial number" 
        value="{{ old('serial_number', $chainsaw->serial_number ?? '') }}" />
    <span id="serial_number_Error" class="error italic"></span>
</div>

<div>
    <label class="block mb-1 font-medium">Brand</label>
    <input type="text" name="brand" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter brand" 
    value="{{ old('brand', $chainsaw->brand ?? '') }}"/>
    <span id="brand_Error" class="error italic"></span>
</div>

<div>
    <label class="block mb-1 font-medium">Model</label>
    <input type="text" name="model" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter model" 
    value="{{ old('model', $chainsaw->model ?? '') }}"/>
    <span id="model_Error" class="error italic"></span>
</div>

<div>
    <label class="block mb-1 font-medium">Bar Length</label>
    <input type="text" name="bar_length" class="w-full p-2 border border-gray-300 rounded"
        placeholder="Enter bar length (inches/cm)" 
        value="{{ old('bar_length', $chainsaw->bar_length ?? '') }}"/>
    <span id="bar_length_Error" class="error italic"></span>
</div>

<div>
    <label class="block mb-1 font-medium">Engine Displacement</label>
    <input type="text" name="engine_displacement" class="w-full p-2 border border-gray-300 rounded"
        placeholder="Enter engine displacement" 
        value="{{ old('engine_displacement', $chainsaw->engine_displacement ?? '') }}"/>
    <span id="engine_displacement_Error" class="error italic"></span>
</div>

<div>
    <label class="block mb-1 font-medium">Date of Acquisition</label>
    <input type="date" name="date_acquisition" class="w-full p-2 border border-gray-300 rounded"
    value="{{ old('date_acquisition', $chainsaw->date_acquisition ?? '') }}" />
    <span id="date_acquisition_Error" class="error italic"></span>
</div>
