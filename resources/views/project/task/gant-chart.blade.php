{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dự án') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="  mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-6 text-gray-900 d-flex justify-content-between">
                     <div></div>
                     @include('project.partials.project-search')
                 </div>
                <div class="p-6 text-gray-900 row">
                    <div class="col-3">@include('project.task.detail-project')</div>
                    <div class="col">
                        <h3 class="h3 text-center">{{ $project->projectName	 }}</h3>
                        <div class="row mb-2">
                            <a href="{{ route('view.task',$project->id) }}" class="col-1 btn btn-outline-dark ">dạng bảng</a>
                            <a href="#" class="col-2 btn btn-outline-dark mx-2 disabled">Biểu đồ grantt</a>
                            <div class="col"></div>
                        </div>
                        <section>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mermaid">
                                            gantt
                                                
                                                dateFormat  YYYY-MM-DD
                                                section Thiết lập dự án
                                                Khởi tạo dự án Laravel    :a1, 2024-01-01, 3d
                                                Cài đặt các dependencies  :a2, after a1, 2d
                                                
                                                section Database
                                                Thiết kế CSDL     :b1, after a2, 4d
                                                Migration         :b2, after b1, 2d
                                                Seeding Data     :b3, after b2, 2d
                                                
                                                section Backend
                                                API Development   :c1, after b3, 7d
                                                Authentication    :c2, after c1, 3d
                                                Testing          :c3, after c2, 4d
                                                
                                                section Frontend
                                                Layout Design     :d1, after c2, 5d
                                                Component Dev     :d2, after d1, 6d
                                                Integration      :d3, after d2, 4d
                                                
                                                section Kiểm thử & Triển khai
                                                Testing          :e1, after d3, 5d
                                                Bug Fixing       :e2, after e1, 3d
                                                Deployment       :e3, after e2, 2d
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </section>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <script>
        // Lấy giá trị ngày từ data attribute
        const startDate = document.querySelector('.date-container').getAttribute('data-start-date');
        const endDate = document.querySelector('.date-container').getAttribute('data-end-date');
    
        // Hàm định dạng ngày theo d/m/Y
        function formatDate(dateString) {
            const date = new Date(dateString); // Chuyển đổi chuỗi thành đối tượng Date
            const day = String(date.getDate()).padStart(2, '0'); // Lấy ngày (dd)
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Lấy tháng (mm)
            const year = date.getFullYear(); // Lấy năm (yyyy)
            
            return `${day}/${month}/${year}`; // Trả về chuỗi ngày theo d/m/Y
        }
    
        // Hiển thị ngày đã định dạng trong HTML
        document.querySelector('.date-container').innerHTML = 'Từ ' + formatDate(startDate) + ' Đến ' + formatDate(endDate);
    </script>
    <script>document.addEventListener('DOMContentLoaded', function() {
        mermaid.initialize({
            startOnLoad: true,
            theme: 'default'
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>

</x-app-layout>
 --}}
    {{-- <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gantt Chart with Dependencies</title>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['gantt']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Task ID');
                data.addColumn('string', 'Task Name');
                data.addColumn('date', 'Start Date');
                data.addColumn('date', 'End Date');
                data.addColumn('number', 'Duration');
                data.addColumn('number', 'Percent Complete');
                data.addColumn('string', 'Dependencies');

                data.addRows([
                    @foreach($tasks as $task)
                    [
                        '{{ $task->id }}', // Task ID
                        '{{ $task->task_name }}', // Task Name
                        new Date({{ date('Y', strtotime($task->start)) }}, {{ date('m', strtotime($task->start)) - 1 }}, {{ date('d', strtotime($task->start)) }}), // Start Date
                        new Date({{ date('Y', strtotime($task->end)) }}, {{ date('m', strtotime($task->end)) - 1 }}, {{ date('d', strtotime($task->end)) }}),   // End Date
                        null, // Duration
                        100, // Percent Complete
                        '{{ $task->parent_id ? $task->parent_id : '' }}' // Dependencies (Nếu có parent_id thì thể hiện phụ thuộc)
                    ],
                    @endforeach
                ]);

                var options = {
                    height: 400,
                    gantt: {
                        trackHeight: 30
                    }
                };

                var chart = new google.visualization.Gantt(document.getElementById('gantt_chart'));
                chart.draw(data, options);
            }
        </script>
    </head>
    <body>
        <h1>Biểu đồ Gantt với Phụ Thuộc</h1>
        <div id="gantt_chart" style="width: 100%; height: 400px;"></div>
    </body>
    </html> --}}


<!-- Trong file layout của bạn -->
<head>
    <!-- Thêm style này vào phần head -->
    <style>
        .mermaid {
            visibility: hidden;
        }
        .mermaid[data-processed="true"] {
            visibility: visible;
        }
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 200px;
        }
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <!-- Thêm Mermaid.js -->
    <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
</head>

<!-- Trong view của bạn -->
<div class="container">
    
    
    <div class="mermaid">
        gantt
            title {{ $project->projectName }}
            dateFormat  YYYY-MM-DD
            @foreach($tasks as $task)
                @if($task->stt == 1)
                    section {{ $task->task_name }}
                    {{ $task->task_name }}     :{{ $task->stt }}, {{ $task->start }}, 3d
                @endif
                @foreach(App\Models\Task::all() as $sonTask)
                    @if($task->id == $sonTask->parent_id)
                    {{ $sonTask->task_name }} :{{ $sonTask->stt }},after {{ $sonTask->stt }} , 3d
                    @endif

                @endforeach
            @endforeach
            
            
             {{-- section Database
            Thiết kế CSDL     :b1, after a2, 4d
            Migration         :b2, after b1, 2d
            Seeding Data     :b3, after b2, 2d
            
            section Backend
            API Development   :c1, after b3, 7d
            Authentication    :c2, after c1, 3d
            Testing          :c3, after c2, 4d
            
            section Frontend
            Layout Design     :d1, after c2, 5d
            Component Dev     :d2, after d1, 6d
            Integration      :d3, after d2, 4d
            
            section Kiểm thử & Triển khai
            Testing          :e1, after d3, 5d
            Bug Fixing       :e2, after e1, 3d
            Deployment       :e3, after e2, 2d --}}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Khởi tạo Mermaid với callback
        mermaid.initialize({
            startOnLoad: true,
            theme: 'default',
            securityLevel: 'loose',
            callbacks: {
                // Callback này sẽ chạy sau khi biểu đồ được render
                postRenderCallback: function() {
                    // Ẩn loading spinner
                    document.getElementById('loadingSpinner').style.display = 'none';
                    // Hiện biểu đồ
                    document.querySelector('.mermaid').style.visibility = 'visible';
                }
            }
        });
    });
</script> 
