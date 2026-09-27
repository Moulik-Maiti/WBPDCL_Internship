<x-app-layout>
    <x-slot name="header">
        <div class= "flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
            </h2>
            <a href="{{route('report.create')}}" class ="bg-slate-700 text-white text-sm rounded-md px-3 py-3 hover:bg-slate-500">Create</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 rounded-md">
        <form action="{{ route('report.index') }} " method="GET">
            @csrf

            <div class="flex justify-between">
            <div class= "flex item-center gap-2 mb-6 ">
            <label class="block text-lg font-medium">Search-</label>
                <input type="text" id="search" name="search" placeholder="Enter Data to be Searched" 
                class="border rounded-md shadow-md px-2 py-1 bg-white">
            </div>

            <div class= "flex item-center gap-2 mb-6">
            <label class="block text-lg font-medium">Status-</label>
            <select id="status" name="status_id" class="border shadow-md rounded-md sm:px-3 lg:py-2 w-40" >
                <option value="">ALL</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{request('status_id')==$status->id ? 'selected': ''}}>
                        {{$status->Status}}
                    </option>
                @endforeach
            </select>
            </div>
            
            <div class="flex items-center gap-2 mb-6">
                <label class="text-lg font-medium">Dates-</label>

                    <input type="text" id="dates" class="border rounded-md shadow-md px-3 py-2 w-72"
                    placeholder="Select multiple dates">
                </div>

            <div class= "flex item-center gap-2 mb-6">
                <a href="{{route('report.index')}}" 
                class="bg-slate-700 text-white text-sm rounded-md shadow-md px-3 py-2 w-30 hover:bg-slate-500">
                Back
            </a>
            </div>
        </div>
        <div class="flex item-start mb-6">
                <a href="{{route('report.export')}}" id="exportBtn" class="ml-auto bg-green-600 text-white text-sm shadow-md rounded-md px-3 py-2 
                hover:bg-green-400 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 group">
                    Export
                </a>
            </div>
        </form>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 rounded-md">
        <x-message ></x-message>
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200">
         <table class="w-full border sm:px-3 lg:py-2">
            <thead class="bg-gray-50">
                <tr class="border-b">
                    <th class= "px-6 py-3 text-left">Date</th>
                    <th class= "px-6 py-3 text-left">W-NO/Username</th>
                    <th class= "px-6 py-3 text-left">Report</th>
                    <th class= "px-6 py-3 text-left">Status</th>
                    <th class= "px-6 py-3 text-left">Additional Information</th>
                    <th class= "px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody id="reportTable" class="bg-white rounded-md">
                @if ($reports->isNotEmpty())
                    @foreach ($reports as $report)
                <tr class="border-b">
                    <td class= "px-6 py-3 text-left">
                        {{$report->created_at->format('d-m-Y')}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$report->username}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$report->report}}
                    </td>
                    <td class= "px-6 py-3 text-left ">
                        {{$report->status->Status}}
                    </td>
                    <td class= "px-6 py-3 text-left">
                        {{$report->additional_information}}
                    </td >
                    <td class= "px-6 py-3">
                        <div class="flex item-right gap-1">
                    <a href="{{ route('report.edit', $report->id) }}" 
                        class="bg-slate-700 text-white text-sm rounded-md px-3 py-2 hover:bg-slate-500 ">
                        Edit
                    </a>

                    <a href="{{ route('report.history', $report->id) }}" 
                        class ="bg-slate-700 text-white text-sm rounded-md px-2 py-2 hover:bg-slate-500 ">
                        History
                    </a>
                    <form action="{{ route('report.destroy', $report->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this report?')" 
                        class="bg-red-700 text-white text-sm rounded-md px-3 py-2 hover:bg-red-600">Delete
                        </button>
                    </form>
                    </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
         </table>
        </div>
        </div>
    
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 rounded-md">
            <div id="pagination" class="my-3 scale-90 text-sm">
                {{$reports->links()}}
            </div>
        </div>
    </div>
    
     <x-slot name="script">

        <script type="text/javascript">
            let timer;
            let selectedDates=[];
            document.addEventListener("DOMContentLoaded", function(){
            flatpickr("#dates",{
                mode: "range",
                dateFormat : "Y-m-d",
                onChange: function(selectedDatesObj){
                    if (selectedDatesObj.length === 2){
                        const start = selectedDatesObj[0];
                        const end = selectedDatesObj[1];

                        let dates = [];
                        for(let d = new Date(start.getTime()); d <=end; d.setDate(d.getDate() + 1)){
                            dates.push(flatpickr.formatDate(d, "Y-m-d"));
                        }
                        selectedDates = dates;
                    }else{
                        selectedDates = []; 
                    }         
                    updateExportLink();
                    fetchReports();
                }
                
            });
            document.getElementById('pagination').addEventListener('click',function(e){
                const link = e.target.closest('a');
                if(!link) return;
                e.preventDefault();
                const url = new URL(link.href);
                const page = url.searchParams.get('page');

                fetchReports(page);
                updateExportLink();
                });
            document.getElementById('search').addEventListener('input', function () {
                fetchReports();
                updateExportLink();
            });

            document.getElementById('status').addEventListener('change', function () {
                fetchReports();
                updateExportLink();
            });
            updateExportLink();
        });
            function fetchReports(page = 1){
                clearTimeout(timer);
                timer = setTimeout(()=>{
                let search = document.getElementById('search').value;
                let status = document.getElementById('status').value;
                let params= new URLSearchParams();
                params.append("search", search);
                params.append("status_id", status);
                params.append("page", page)

                selectedDates.forEach(date => {
                    params.append('dates[]', date)
                });

                fetch(`/report/search?${params.toString()}`)
                .then(response => {
                    console.log(response.status);
                    if(!response.ok){
                        throw new Error("HTTP" + response.status);                       
                    }
                    return response.json();
                })
                .then(data =>{
                    let table = '';
                    if (data.data.length === 0) {
                        table = `
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                No reports found
                            </td>
                        </tr>`;
                    }
                    else{
                    data.data.forEach(report=> {
                        let d = new Date(report.created_at);
                        let formattedDate = String(d.getDate()).padStart(2, '0') + "-" + String(d.getMonth() + 1).padStart(2, '0') + "-" + d.getFullYear();
                        table += `
                        <tr class = "border-b">
                          <td class="px-6 py-3 text-left">
                            ${formattedDate}
                        </td>

                        <td class="px-6 py-3 text-left">
                            ${report.username}
                        </td>

                        <td class="px-6 py-3 text-left">
                            ${report.report}
                        </td>

                        <td class="px-6 py-3 text-left whitespace-nowrap">
                            ${report.status ? report.status.Status : ''}
                        </td>

                        <td class="px-6 py-3 text-left">
                            ${report.additional_information ?? ''}
                        </td>
                        <td class="px-6 py-3 text-center">
                            <div class="flex gap-2">
                            <a href="/report/${report.id}/edit" class="bg-slate-700 text-white text-sm rounded-md px-3 py-2 hover:bg-slate-500">Edit</a>
                            
                            <a href="/report/${report.id}/history" class="bg-slate-700 text-white text-sm rounded-md px-3 py-2 hover:bg-slate-500">History</a>

                            <form action="/report/${report.id}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this report?')"
                                class="bg-red-700 text-white text-sm rounded-md px-3 py-2">
                                    Delete
                                </button>
                            </form>
                            </div>
                        </td>
                        </tr>
                        `;
                    });
                }
                    const exportBtn= document.getElementById("exportBtn");
                    if (data.data.length === 0){
                        exportBtn.classList.add("hidden");
                    }else{
                        exportBtn.classList.remove("hidden");
                    }
                    document.getElementById('reportTable').innerHTML = table;
                    document.getElementById('pagination').innerHTML = data.pagination;
                    updateExportLink();
                })
                .catch(error => {
                    console.error(error);
                });
            },300);
                           
        }  
        function updateExportLink() {
            const search = document.getElementById('search').value;
            const status = document.getElementById('status').value;

            const params = new URLSearchParams();

            if (search) {
                params.append('search', search);
            }

            if (status) {
                params.append('status_id', status);
            }

            // Add all selected dates
            selectedDates.forEach(date => {
                params.append('dates[]', date);
            });

            document.getElementById('exportBtn').href =
                '/report/export?' + params.toString();
        }
        
        </script>
    </x-slot>
</x-app-layout>