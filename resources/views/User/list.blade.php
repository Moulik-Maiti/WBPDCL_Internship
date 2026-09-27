<x-app-layout>
    <x-slot name="header">
        <div class= "flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
            </h2>
            <a href="{{route('user.create')}}" 
            class="bg-slate-700 px-3 py-2 text-white text-sm rounded-md hover:bg-slate-500" >
            Create
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

         <x-message></x-message>
        <div class="rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="w-full shadow-lg ">
            <thead class="bg-gray-50">
                <tr class="border-b">
                    <th class= "px-6 py-3 text-left">#</th>
                    <th class= "px-6 py-3 text-left">Name</th>
                    <th class= "px-6 py-3 text-left">Email</th>
                    <th class= "px-6 py-3 text-left">Roles</th>
                    <th class= "px-6 py-3 text-left">Time</th>
                    <th class= "px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if ($users->count())
                    @foreach ($users as $user)
                <tr class="border-b">
                    <td class= "px-6 py-3 text-left">
                        {{$user->id}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$user->name}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$user->email}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$user->roles->pluck('name')->implode(', ')}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$user->updated_at->format('d-m-Y H:i:s')}}
                    </td>
                    <td class= "px-6 py-3 text-center">
                        <a href="{{route('user.edit',$user->id) }}" 
                        class ="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-500">Edit</a>

                        <a href="javascript:void(0);" onclick="deleteUser({{$user->id}})" 
                        class ="bg-red-700 text-white text-sm rounded-md px-3 py-2 hover:bg-red-600">Delete</a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
         </table>
         </div>
    </div>
</div>


<div class="max-w-6xl mx-auto sm:px-6 lg:px-6">
    <div class="my-3">
        {{$users->links()}}
    </div>
</div>

<x-slot name="script">
        <script type="text/javascript">
            function deleteUser(id){
                if (confirm("Are you sure you want to Delete")){
                    $.ajax({
                        url :'{{route("user.destroy", ":id")}}'.replace(':id', id),
                        type: 'delete',
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function(response){
                            window.location.href = "{{route("user.index")}}";
                        }
                    });
                }
            }
        </script>
    </x-slot>

</x-app-layout>