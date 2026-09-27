<x-app-layout>
    <x-slot name="header">
         <div class= "flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users / Create
            </h2>

            <a href="{{route('user.index')}}" class ="bg-slate-700 text-white text-sm rounded-md px-3 py-2">Back</a>
        
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input value="{{old('name')}}" name="name"
                                class=" border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder= "Enter User Name">
                                @error('name')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="" class="text-lg font-medium">Email</label>
                            <div class="my-3">
                                <input value="{{old('email')}}" name="email" type="email"
                                class=" border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder= "Enter User Email">
                                @error('email')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="" class="text-lg font-medium">Password</label>
                            <div class="my-3">
                                <input  name="password" type="password" autocomplete="new-password"
                                class=" border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder= "Enter Password">
                                @error('password')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="" class="text-lg font-medium">Confirm Password</label>
                            <div class="my-3">
                                <input name="password_confirmation" type="password" autocomplete="new-password"
                                class=" border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder= "Confirm Your Password">
                                @error('password_confirmation')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-4 mb-3">
                                @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                    <div class="mt-3">
                                        <input  type="checkbox" id="role-{{ $role->id }}" name="role[]" 
                                        value="{{ $role->id }}" class="rounded">
                                        <label for="role-{{ $role->id }}" class="text-gray-700">{{ $role->name }}</label>
                                    </div>
                                    @endforeach
                                    @endif

                            </div>
                            <button class ="bg-slate-700 text-sm text-white rounded-md px-5 py-4 hover:bg-slate-500">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
