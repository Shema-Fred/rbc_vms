<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Vehicle Requests
    </h2>
  </x-slot>

  @if (!Auth::user()->hasRole('driver'))
  <div class="py-12 px-20">

    @if(Session::has('message'))
    <div class="bg-green-300 text-green-700 rounded py-3 text-center px-8 mx-auto" style="width: fit-content">
      {{Session::get('message')}}
    </div>
    @endif

    @if (auth()->user()->hasRole('staff'))
    <div class="grid justify-items-stretch my-3">
      <a href="{{route('vehicleRequest.create')}}"
        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 flex justify-self-end">
        Request Vehicle
      </a>
    </div>
    @endif

    <div class="table-responsive">
      <table class="w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th style="width: 1px" class="text-left relative px-6 py-3">#</th>
            <th class="text-left relative px-6 py-3">Name</th>
            <th class="text-left relative px-6 py-3">Driver</th>
            <th class="text-left relative px-6 py-3">Destination</th>
            <th class="text-left relative px-6 py-3">Deadline</th>
            <th class="text-left relative px-6 py-3">Status</th>
            <th class="text-left relative px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($vehicleRequests as $vehicleRequest)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{$loop->iteration}}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$vehicleRequest->user->name ?? 'N/A'}}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$vehicleRequest->vehicle->driver->name ?? 'N/A'}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-capitalize">{{$vehicleRequest->destination ?? 'N/A'}}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$vehicleRequest->deadline ?? 'N/A'}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-capitalize">{{$vehicleRequest->status}}</td>
            <td class="px-6 py-4 whitespace-nowrap flex justify-center ">
              @if (auth()->user()->hasRole('staff'))
              <a href="{{route('vehicleRequest.edit', [$vehicleRequest->id])}}" class="text-blue-500 mx-2">Edit</a>
              @endif

              @if (auth()->user()->hasRole('admin'))
              <a href="{{route('vehicleRequest.edit', [$vehicleRequest->id])}}" class="text-blue-500 mx-2">Edit</a>

              <form method="post" action="{{route('vehicleRequest.destroy', [$vehicleRequest->id])}}"
                id="deleteForm{{$vehicleRequest->id}}">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 mx-2"
                  onclick="event.preventDefault(); if(confirm('Are you sure to delete?')) {document.getElementById('deleteForm{{$vehicleRequest->id}}').submit();} else {return false;} ">Delete</button>
              </form>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="px-6 py-4 whitespace-nowrap h-20 text-center">No vehicle requests to display</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="my-3">
      {{$vehicleRequests->links()}}
    </div>
  </div>
  @endif
</x-app-layout>