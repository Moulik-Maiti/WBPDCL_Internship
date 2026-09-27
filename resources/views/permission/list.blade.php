<x-app-layout>
    <x-slot name="header">
        <div class= "flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
            </h2>
            <a href="{{route('permission.create')}}" class ="bg-slate-700 text-white text-sm rounded-md px-3 py-3">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <x-message></x-message>

        <div class="rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
         <table class="w-full ">
            <thead class="bg-gray-50">
                <tr class="border-b">
                    <th class= "px-6 py-3 text-left">#</th>
                    <th class= "px-6 py-3 text-left">Name</th>
                    <th class= "px-6 py-3 text-left">Created</th>
                    <th class= "px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white" rounded-md>
                @if ($permissions->isNotEmpty())
                    @foreach ($permissions as $permission)
                <tr class="border-b">
                    <td class= "px-6 py-3 text-left">
                        {{$permission->id}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$permission->name}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$permission->created_at}}
                    </td>
                    <td class= "px-6 py-3 text-center">
                        <a href= "{{ route('permission.edit',$permission->id) }}" style="margin-right: 10px;"
                        class ="bg-slate-700 text-white text-sm rounded-md px-3 py-3 hover:bg-slate-600">Edit</a>

                        <a href="javascript:void(0);" onclick="deletePermission({{$permission->id}})" 
                        class ="bg-red-700 text-white text-sm rounded-md px-3 py-3 hover:bg-red-600">Delete</a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
         </table>
        </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="my-3">
                {{$permissions->links()}}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deletePermission(id){
                if (confirm("Are you sure you want to Delete")){
                    $.ajax({
                        url :'{{route("permission.destroy", ":id")}}'.replace(':id', id),
                        type: 'delete',
                        data: {id:id},
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function(response){
                            window.location.href = "{{route("permission.index")}}";
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>