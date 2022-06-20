<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Update Request
    </h2>
  </x-slot>

  <div class="py-12 px-20 mx-auto" style="max-width: 620px">

    <form method="post" action="{{route('vehicleRequest.update',$vehicleRequest->id)}}">
      @csrf
      @method('PUT')
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
          @if(Auth::user()->hasRole('staff'))
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Description
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <textarea type="text" name="description" rows="3"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('description') border-red-500 @enderror"
                placeholder="Desription">{{$vehicleRequest->description}}</textarea>
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
                <option value="kigali" @selected($vehicleRequest->destination==='kigali' )>Kigali</option>
                <option value="field" @selected($vehicleRequest->destination==='field' )>Field</option>
              </select>
            </div>
            @error('destination')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>

          @endif
          @if (Auth::user()->hasRole('admin'))
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Deadline
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <input type="text" name="deadline" id="deadline" value="{{$vehicleRequest->deadline}}"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('deadline') border-red-500 @enderror"
                placeholder="Deadline">
            </div>
            @error('deadline')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>

          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Vehicle
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <select name="vehicle_id"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('vehicle_id') border-red-500 @enderror">
                <option value="" disabled selected>Select Vehicle</option>
                @if ($vehicles->count() < 1 && $vehicleRequest->vehicle_id)
                  <option value="{{$vehicleRequest->vehicle_id}}" selected>
                    {{$vehicleRequest->vehicle->name}} &nbsp; &nbsp; &nbsp; {{$vehicleRequest->vehicle->plate}}
                  </option>
                  @else
                  @foreach ($vehicles as $vehicle)
                  <option value="{{$vehicle->id}}" @selected($vehicleRequest->role===$vehicle->id)>
                    {{$vehicle->name}} &nbsp; &nbsp; &nbsp; {{$vehicle->plate}}
                  </option>
                  @endforeach
                  @endif
              </select>
            </div>
            @error('vehicle_id')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>

          {{--status field--}}
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Status
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <select name="status"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('status') border-red-500 @enderror">
                <option value="" disabled selected>Select Status</option>
                <option value="pending" @selected($vehicleRequest->status==='pending')>Pending</option>
                <option value="approved" @selected($vehicleRequest->status==='approved')>Approved</option>
                <option value="rejected" @selected($vehicleRequest->status==='rejected')>Rejected</option>
              </select>
            </div>
            @error('status')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>
          @endif
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <a href="{{route('vehicleRequest.index')}}"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
            Cancel
          </a>
          <button type="submit"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Update
          </button>
        </div>
      </div>

    </form>

  </div>

  @section('scripts')
  <script>
    var fp = flatpickr('#deadline', {
      enableTime: true,
      dateFormat: "d-m-Y H:i",
      defaultDate: "{{$vehicleRequest->deadline ?? 'today'}}",
      time_24hr: true,
    });
  </script>
  @endsection
</x-app-layout>