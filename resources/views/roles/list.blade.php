<x-app-layout>
    <x-slot name="header">
        <div class= "flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
            </h2>
            <a href="{{route('role.create')}}" class ="bg-slate-700 text-white text-sm rounded-md px-3 py-2 hover:bg-slate-500">Create Roles</a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#E0F2FE]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-[#E0F2FE]">
         <x-message></x-message>
        <div class="rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="w-full shadow-lg">
            <thead class="bg-gray-50">
                <tr class="border-b">
                    <th class= "px-6 py-3 text-left">#</th>
                    <th class= "px-6 py-3 text-left">Name</th>
                    <th class= "px-6 py-3 text-left">Permissions</th>
                    <th class= "px-6 py-3 text-left">Created</th>
                    <th class= "px-6 py-3 text-centre">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if ($role->count())
                    @foreach ($role as $roles)
                <tr class="border-b">
                    <td class= "px-6 py-3 text-left">
                        {{$roles->id}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$roles->name}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$roles->permissions->pluck('name')->implode(', ')}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$roles->created_at}}
                    </td>
                    <td class= "px-6 py-3 text-centre flex justify-center gap-2" >
                        <a href="{{route('role.edit',$roles->id) }}" 
                        class ="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-500">Edit</a>

                        <a href="javascript:void(0);" onclick="deleteRole({{$roles->id}})" 
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

<div class="max-w-7xl mx-auto sm:px-6 lg:px-6 bg-[#E0F2FE]">
    <div class="my-3">
        {{$role->links()}}
    </div>
</div>

    <x-slot name="script">
        <script type="text/javascript">
            function deleteRole(id){
                if (confirm("Are you sure you want to Delete")){
                    $.ajax({
                        url :'{{route("role.destroy", ":id")}}'.replace(':id', id),
                        type: 'delete',
                        data: {id:id},
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function(response){
                            window.location.href = "{{route("role.index")}}";
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>