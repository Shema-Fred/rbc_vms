<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Edit User
    </h2>
  </x-slot>

  <div class="py-12 px-20 mx-auto" style="max-width: 620px">

    <form method="post" action="{{route('user.update', $user->id)}}">
      @csrf
      @method('PUT')
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Name
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <input type="text" name="name" value="{{$user->name}}"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('name') border-red-500 @enderror"
                placeholder="Name">
            </div>
            @error('name')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>

          {{-- Email field --}}
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Email
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <input type="email" name="email" value="{{$user->email}}"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('email') border-red-500 @enderror"
                placeholder="Email">
            </div>
            @error('email')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>

          {{--phone field--}}
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Phone number
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <input type="text" name="phone" value="{{$user->phone}}"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('phone') border-red-500 @enderror"
                placeholder="Phone number">
            </div>
            @error('phone')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>

          {{-- role field --}}
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Role
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <select name="role"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('role') border-red-500 @enderror"
                placeholder="Role">
                <option value="" disabled selected>Select Role</option>
                <option value="admin" @selected($user->role === 'admin')>Admin</option>
                <option value="staff" @selected($user->role === 'staff')>Staff</option>
                <option value="driver" @selected($user->role === 'driver')>Driver</option>
              </select>
            </div>
            @error('role')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>

          {{-- password field --}}
          <div class="col-span-3 sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
              Password
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <input type="password" name="password"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300 @error('password') border-red-500 @enderror"
                placeholder="Password">
            </div>
            @error('password')
            <div class="text-red-600">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <a href="{{route('user.index')}}"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
            Cancel
          </a>
          <button type="submit"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Update User
          </button>
        </div>
      </div>

    </form>

  </div>
</x-app-layout>