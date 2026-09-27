<x-app-layout>
    <x-slot name="header">
        <div class= "flex justify-between ">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History') }}
            </h2>

            <a href="{{route('report.index')}}" class="bg-slate-700 text-white text-sm rounded-md px-3 py-2 hover:bg-slate-500 " >
                Back
            </a>
        </div>
    </x-slot>
    
    <div class="relative">

    <!-- Vertical Line -->
    <div class="absolute left-1/3 -translate-x-1/4 top-0 h-full w-1 bg-gray-300"></div>

    <div>
    <div class="sticky top-1 ml-6 w-[450px] bg-white rounded-xl shadow-lg border p-5">
        <div class="flex flex-col gap-1">
            <h3 class="font-bold text-lg">
                Report Information
            </h3>
        </div>
        <hr class="my-3">
        <div>
            <p>
                <strong>Username/W-NO:</strong>
                    {{$report->username}}
            </p>
            <p>
                <strong>Report:</strong>
                {{$report->report}}
            </p>
        </div>
    </div>

    @foreach($histories as $history)

    <div class="relative flex items-start mb-8 mt-5">

        <!-- Circle -->
        <div class="z-10 w-8 h-8 rounded-full bg-blue-600 border-4 border-white absolute left-1/3 -translate-x-1/3"></div>

        <!-- Box -->
        <div class="mx-auto w-[450px] bg-white rounded-xl shadow-lg border p-5">

            <div class="flex flex-col gap-1 ">

                <h3 class="font-bold text-lg">
                    Report Updated
                </h3>

                <span class="text-sm text-gray-500">
                    {{ $history->created_at->format('d M Y h:i A') }}
                </span>

            </div>

            <hr class="my-3">

            <div class="space-y-2">

                <p>
                    <strong>Created By:</strong>
                    {{ $history->user?->name ?? 'Unknown'}}
                </p>

                <p>
                    <strong>Action:</strong>

                    <span class="text-sm px-3 py-1 rounded-full">
                        {{ $history->action }}
                    </span>
                </p>

                <p>
                    <strong>Status:</strong>
                
                @php
                    $badgeColor = match($history->status) {
                    'Pending' => 'bg-yellow-100 text-yellow-800',
                    'In Progress' => 'bg-blue-100 text-blue-800',
                    'Completed' => 'bg-green-100 text-green-800',
                    'Rejected' => 'bg-red-100 text-red-800',
                    'On Hold' => 'bg-orange-100 text-orange-800',
                    'Cancelled' => 'bg-gray-200 text-gray-800',
                    default => 'bg-slate-100 text-slate-800',
                    };
                @endphp

                    <span class="text-sm px-3 py-1 rounded-full {{ $badgeColor }}">
                        {{ $history->status }}
                    </span>
                </p>
                
                <p>
                    <strong>Remark:</strong>
                </p>
                @if($history->remark)
                <div class="bg-gray-50 border rounded p-3">
                    {!! nl2br(e($history->remark)) !!}
                </div>
                @endif
            </div>

        </div>

    </div>

    @endforeach


</div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="my-3">
                {{$histories->links()}}
            </div>
    </div>
</x-app-layout>