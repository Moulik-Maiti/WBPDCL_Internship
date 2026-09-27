<x-app-layout>
    <x-slot name="header">
         <div class= "flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users / Edit
            </h2>
            <a href="{{route('user.index')}}" class ="bg-slate-700 text-white text-sm rounded-md px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('user.update',$users->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input value="{{old('name',$users->name)}}" name="name" 
                                class=" border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder= "Enter User Name">
                                @error('name')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                                <label for="" class="text-lg font-medium">Email</label>
                            <div class="my-3">
                                <input value="{{old('email',$users->email)}}" name="email" 
                                class=" border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder= "Enter User Email">
                                @error('email')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-4 mb-3">
                                @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                    <div class="mt-3">
                                        <input  type="checkbox" id="role-{{ $role->id }}" name="role[]" 
                                        value="{{ $role->id }}" class="rounded" {{ $users->roles->contains($role->id) ? 'checked' : '' }}>
                                        <label for="role-{{ $role->id }}" class="text-gray-700">{{ $role->name }}</label>
                                    </div>
                                    @endforeach
                                    @endif

                            </div>
                            <button class ="bg-slate-700 text-sm text-white rounded-md px-5 py-4 hover:bg-slate-500">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
