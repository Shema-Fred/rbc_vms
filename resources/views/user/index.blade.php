<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Users
    </h2>
  </x-slot>

  @if (Auth::user()->hasRole('admin'))
  <div class="py-12 px-20">

    @if(Session::has('message'))
    <div class="bg-green-300 text-green-700 rounded py-3 text-center px-8 mx-auto" style="width: fit-content">
      {{Session::get('message')}}
    </div>
    @endif

    <div class="grid justify-items-stretch my-3">
      <a href="{{route('user.create')}}"
        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 flex justify-self-end">
        Create User
      </a>
    </div>

    <div class="table-responsive">
      <table class="w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th style="width: 1px" class="text-left relative px-6 py-3">#</th>
            <th class="text-left relative px-6 py-3">Name</th>
            <th class="text-left relative px-6 py-3">
              Email
            </th>
            <th class="text-left relative px-6 py-3">
              Phone
            </th>
            <th class="text-left relative px-6 py-3">
              Role
            </th>
            <th class="text-left relative px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($users as $user)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{$loop->iteration}}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$user->name}}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$user->email}}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$user->phone}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-capitalize">{{$user->role}}</td>
            <td class="px-6 py-4 whitespace-nowrap flex justify-center ">
              <a href="{{route('user.edit', [$user->id])}}" class="text-blue-500 mx-2">Edit</a>
              <form method="post" action="{{route('user.destroy', [$user->id])}}" id="deleteForm{{$user->id}}">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 mx-2"
                  onclick="event.preventDefault(); if(confirm('Are you sure to delete?')) {document.getElementById('deleteForm{{$user->id}}').submit();} else {return false;} ">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-6 py-4 whitespace-nowrap h-20 text-center">No users to display</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="my-3">
      {{$users->links()}}
    </div>
  </div>
  @endif
</x-app-layout>