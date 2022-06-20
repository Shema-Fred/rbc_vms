<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Request Vehicle
    </h2>
  </x-slot>

  <div class="py-12 px-20 mx-auto" style="max-width: 620px">

    <form method="post" action="{{route('vehicleRequest.store')}}">
      @csrf

      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Description
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <textarea type="text" name="description" rows="3"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('description') border-red-500 @enderror"
                placeholder="Desription">{{old('description')}}</textarea>
            </div>
            @error('description')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>

          {{-- destination field --}}
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Destination
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <select name="destination"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('destination') border-red-500 @enderror"
                placeholder="Destination">
                <option value="" disabled selected>Select Destination</option>
                <option value="kigali" @selected(old('destination')==='kigali' )>Kigali</option>
                <option value="field" @selected(old('destination')==='field' )>Field</option>
              </select>
            </div>
            @error('destination')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>

        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <a href="{{route('vehicleRequest.index')}}"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
            Cancel
          </a>
          <button type="submit"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Request Vehicle
          </button>
        </div>
      </div>

    </form>

  </div>
</x-app-layout>