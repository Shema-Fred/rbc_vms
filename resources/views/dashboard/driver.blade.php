<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vehicles
        </h2>
    </x-slot>
    <div class="py-12 px-20">

        @if(Session::has('message'))
        <div class="bg-green-300 text-green-700 rounded py-3 text-center px-8 mx-auto" style="width: fit-content">
            {{Session::get('message')}}
        </div>
        @endif

        <div class="table-responsive">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th style="width: 1px" class="text-left relative px-6 py-3">#</th>
                        <th class="text-left relative px-6 py-3">Name</th>
                        <th class="text-left relative px-6 py-3">
                            Driver
                        </th>
                        <th class="text-left relative px-6 py-3">
                            Plate
                        </th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vehicles as $vehicle)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{$loop->iteration}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$vehicle->name}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$vehicle->driver->name ?? 'N/A'}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$vehicle->plate}}</td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap h-20 text-center">No vehicles to display</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>