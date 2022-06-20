<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Create Vehicle
    </h2>
  </x-slot>

  <div class="py-12 px-20 mx-auto" style="max-width: 620px">

    <form method="post" action="{{route('vehicle.store')}}">
      @csrf

      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Name
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <input type="text" name="name" value="{{old('name')}}"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('name') border-red-500 @enderror"
                placeholder="Name">
            </div>
            @error('name')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>

          {{-- Plate field --}}
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Plate number
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <input type="text" name="plate" value="{{old('plate')}}"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('plate') border-red-500 @enderror"
                placeholder="Plate number">
            </div>
            @error('plate')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>

          {{-- driver_id field --}}
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Driver
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <select name="driver_id"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('driver_id') border-red-500 @enderror">
                <option value="" disabled selected>Select driver</option>
                @foreach($drivers as $driver)
                <option value="{{$driver->id}}" @selected(old('driver_id')===$driver->id)>
                  {{$driver->name}}
                </option>
                @endforeach
              </select>
            </div>
            @error('driver_id')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>


        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <a href="{{route('vehicle.index')}}"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
            Cancel
          </a>
          <button type="submit"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Create Vehicle
          </button>
        </div>
      </div>

    </form>

  </div>
</x-app-layout>