
<link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
<div class="mb-5">
    <div class="row">
        <h3 class="h3 col-6">Thông tin dự án</h3>
        <h3 class="col">Thư mục dự án</h3>

    </div>
    <div>
        @if($project->status != 2 &&  Auth::user()->role === "admin" || $project->status != 2 &&  Auth::user()->role === "root")

        <a href="{{ route('project.toggleStar',$project->id) }}" class=" mt-2" > @if( $project->toggleStar == 1) <i class="fa-solid fa-star" style="color: #FFD43B;"></i> @else <i class="fa-regular fa-star" ></i>  @endif </a>
        @endif
    </div>
    <div class="row" >
        <div class="col-6 row">
            
            <div class="circle-k col-3" style="background: @if($project->status == 3) conic-gradient(rgb(255, 0, 0) @else conic-gradient(rgb(49, 164, 7) @endif {{$project->progress}}%, #e0e0e0 0)">
                
                <span class="percentage_k">{{ $project->progress }}%</span>
            </div>
            <div class="col-1"></div>
            <div class="mx-2 col">
                

                <div class=""><span class="h6">Mã:</span> {{ $project->projectCode }}</div>
                <div class=""><span class="h6">Tên:</span> {{ $project->projectName }} </div>
                <div><span class="h6">Ngân sách: </span>{{ $project->budget }}</div>
                <div>
                    <span class="h6">Giám sát công trình:</span> 
                    @foreach(App\Models\WorkingProject::where('project_id',$project->id)->get() as $WorkingProject)
                        @if($WorkingProject->users) 
                            @if($WorkingProject->is_work == 1)
                            <div>{{ $WorkingProject->users->name }} ( đảm nhận từ {{ $WorkingProject->at_work }} đến {{ $WorkingProject->out_work }} )</div>
                            @else()
                            <div>{{ $WorkingProject->users->name }} ( đang đảm nhận )</div>
                            @endif
                        
                        @endif
                    @endforeach
                    @php
                    $workingProjects = App\Models\WorkingProject::where('project_id', $project->id)->get();
                    @endphp
                    
                    @if($workingProjects->isEmpty())    
                    <div>{{ $project->user->name }}</div>

                    
                    @endif
                </div>
                <div><span class="h6">Trạng thái: </span>
                    @if($project->status == 1)   
                                            Đã hoàn thành

                                        @elseif($project->status ==2)
                                            Tạm dừng
                                        @elseif($project->status ==0)
                                            Đang tiến hành

                                        @elseif($project->status ==3)
                                            Chậm tiến độ 
                                        @endif
                </div>
                <div class=""><span class="h6">Loại công trình: </span>{{ $project->type }}</div>
                <div class=""><span class="h6">Quy mô: </span>{{ $project->level }}</div>
                <div><span class="h6">Khởi công: </span>{{ $project->startDate }}</div>
               
                <div class="">
                    <span class="h6">Hoàn thành dự kiến: </span>{{ $project->endDate }}
                </div>
                <div class=""><span class="h6">Đối tác:</span> {{ $project->contractors->name }}</div>
                <div class=""><span class="h6">Địa điểm thi công:</span> {{ $project->address }}</div>
            </div>
        </div>
        <div class="col">
            @include('supervisor.task.add-do')




            <span class="h6 ms-5">Mô tả dự án: </span>
            <div class="ms-5"> {{ $project->description }}</div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12 ">
            <h3 class="">Danh sách công việc</h3>

            <div class="">
                <div class="">
                    

                    <div class="table-responsive">
                        <table id="taskList" class="table">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th></th>
                                <th>Mã </th>
                                <th>Tên công việc</th>
                                <th>Mô tả</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày hoàn thành</th>
                                <th>Thời gian (ngày)</th>
                                <th>phụ trách</th>
                                <th>Trạng thái</th>
                                <th>Tiến độ</th>
                            </tr>
                            </thead>
                            @php $counter = 1; @endphp
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td><div class="mt-3">{{ $counter }}</div></td>
                                    <td>                                            
                                        <a href="{{ route('task.toggleStar',$task->id) }}" class="d-flex flex-row-reverse mt-3" > @if( $task->star == 1) <i class="fa-solid fa-star" style="color: #FFD43B;"></i> @else <i class="fa-regular fa-star" ></i>  @endif </a>                                    
                                    </td>
                                        @php $counter++; @endphp
                                    <td><div class="mt-3">{{ $task->task_code }}</div></td>
                                    <td><div class="mt-3">{{ $task->task_name }}</div></td>
                                    <td><div class="mt-3">{{ $task->note }}</div></td>
                                    <td><div class="mt-3">{{ $task->startDate }}</div></td>
                                    <td><div class="mt-3">{{ $task->endDate }}</div></td>
                                    
                                    <td><div class="mt-3">{{ $task->duration }} ngày</div></td>
                                    <td><div class="mt-3">{{ $task->users->name }} </div></td>
                                    <td>
                                        <div class="mt-3">@if( $task->status == 0)
                                            <span class="badge bg-primary-subtle text-primary border border-primary d-inline-flex align-items-center">
                                                Đang tiến hành
                                            </span>
                                        @elseif($task->status == 1)
                                            <span class="badge bg-success-subtle text-success border border-success d-inline-flex align-items-center">
                                                Đã hoàng thành
                                            </span>
                                        @elseif($task->status == 2)
                                            <span class="badge bg-warning-subtle text-warning border border-warning d-inline-flex align-items-center">
                                            Chậm tiến độ
                                            </span>
                                        @else 
                                            <span class="badge bg-danger-subtle text-danger border border-danger d-inline-flex align-items-center">
                                                Tạm dừng
                                            </span>
                                        @endif </div>

                                    </td>
                                    <td><div class="mt-3">{{ $task->progress }} %</div></td>
                                    
        
                                </tr>
                                
                            @endforeach
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>{{-- dạng bảng --}}
    
    <script>
        $(document).ready(function() {
            $('#taskList').DataTable({
                columnDefs: [
                    { orderable: false, targets: 11 } // Chỉ định cột thứ 2 không cho phép sắp xếp
                ]
            });
        });
        </script>
        
        <script>
            $(document).ready(function() {
                $('#importTaskForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    // Reset các thông báo lỗi cũ
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    
                    const fileInput = $('#fileInput');
                    const file = fileInput[0].files[0];
                    const maxSize = 8 * 1024 * 1024; // 8MB
                    let hasError = false;
                    
                    // Kiểm tra file có được chọn không
                    if (!file) {
                        showError(fileInput, 'Vui lòng chọn file');
                        hasError = true;
                        return;
                    }
                    
                    // Kiểm tra định dạng file
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    if (!['xlsx', 'xls', 'csv'].includes(fileExtension)) {
                        showError(fileInput, 'File phải có định dạng .xlsx, .xls hoặc .csv');
                        hasError = true;
                        return;
                    }
                    
                    // Kiểm tra kích thước file
                    if (file.size > maxSize) {
                        showError(fileInput, 'Kích thước file không được vượt quá 8MB');
                        hasError = true;
                        return;
                    }
                    
                    // Nếu không có lỗi thì submit form
                    if (!hasError) {
                        this.submit();
                    }
                });
            
                // Hàm hiển thị lỗi
                function showError(element, message) {
                    element.addClass('is-invalid');
                    element.after(`<div class="invalid-feedback">${message}</div>`);
                }
            
                // Reset lỗi khi chọn file mới
                $('#fileInput').on('change', function() {
                    $(this).removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                });
            });
            </script>