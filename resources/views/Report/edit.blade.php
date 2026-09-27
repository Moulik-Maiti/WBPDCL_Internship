<x-app-layout>
    <x-slot name="header">
         <div class= "flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Report / Edit
            </h2>
            <a href="{{route('report.index')}}" class ="bg-slate-700 text-white text-sm rounded-md px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('report.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="" class="text-lg font-medium">W-NO/Username</label>
                            <div class="my-3">
                                <input value= "{{ old('username',$report->username ?? '') }}" name= "username" 
                                class=" border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder = "W-NO/Username">
                                @error('username')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="" class="text-lg font-medium">Report</label>
                            <div class="my-3">
                                <input value= "{{ old('report',$report->report ?? '') }}"name="report" 
                                class=" border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder= "Report">
                                @error('report')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                </div>
                            </div>

                            <label for="" class="text-lg font-medium">Status</label>
                            <div class="my-3 rounded-md">
                                <select name="status_id" class="border-gray-300 shadow-sm rounded-lg">
                                    @foreach($statuses as $status)
                                        <option  value="{{ $status->id }}" 
                                        {{old('status_id', $report->status_id) == $status->id ? 'selected' : ''}} >
                                            {{$status->Status}}
                                        </option>
                                    @endforeach
                                </select>
                                
                                @error('status')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="" class="text-lg font-medium">Additional Information</label>
                            <div class="my-3">
                                <textarea name="additional_information" placeholder="Additional Information"
                                class=" border-gray-200 shadow-sm w-1/2 rounded-lg" cols="20" rows="10">
                                {{ old('additional_information', $report->additional_information ?? '') }}
                            </textarea>
                            </div>
                            <button class ="bg-slate-700 text-sm text-white rounded-md px-5 py-4">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>      
</x-app-layout>
