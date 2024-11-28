@include('admin.task.detail-project')


{{-- dạng bảng --}}
    <div class="row mt-5">
        <div class="col-md-12 ">
            <h3 class="">Danh sách công việc</h3>

            <div class="">
                <div class="">
                    <div class="d-flex">
                        @if($project->status != 2 )
                        <div class="mb-3 mt-3 me-3">

                            <a type="button" class="btn btn-outline-primary" title="Thêm công việc"  data-bs-toggle="modal" data-bs-target="#myModal">
                                <div class="d-flex"><i class="icon text-muted" data-feather="plus"></i> Thêm công việc</div>
                            </a>
                                
                            <!-- add task -->
                            <div class="modal" id="myModal">
                                <div class="modal-dialog  modal-lg">
                                    <div class="modal-content">
                                
                                        <div class="modal-header">
                                            <h4 class="modal-title">Thêm Công việc</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                                                                                                    
                                        <div class="modal-body">
                                            <form action="{{ route('task.store') }}" method="post" enctype="multipart/form-data" id="signupForm">
                                                @csrf
                                                <h5>Dự án: {{ $project->projectName }}</h5>
                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <lablel for="task_name">Mã công việc:</lablel>
                                                        <input class="form-control" value="" type="text" name="task_code" id="task_code" value="">
                                                    </div>    
                                                    <div class="col">
                                                        <lablel for="task_name">Tên công việc:</lablel>
                                                        <input class="form-control" type="text" name="task_name" id="task_name">
                                                    </div>    
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <lablel>Sau công việc:</lablel>
                                                        <select class="form-select" id="parentID" name="parentID">
                                                            <option selected disabled> Chọn công việc tiên quyết</option>
                                                            <option value="0">Công việc đầu tiên</option>
                                                            @foreach($tasks as $task)
                                                                
                                                                <option value="{{ $task->id }}">Sau {{ $task->task_name }}</option>
                                                                    
                                                            @endforeach
                                                        </select>
                                                    </div>    
                                                </div>
                                                
                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <lablel>Ngày bắt đầu:</lablel>
                                                        <input  class="form-control" id="startDate" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd" placeholder="" name="startDate" required>
                                                    </div>    
                                                    <div class="col">
                                                        <lablel>Ngày kết thúc:</lablel>
                                                        <input  class="form-control" id="endDate" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd" placeholder="" name="endDate" required>
                                                    </div>
                                                    <div class="col">
                                                        <lablel>Chi phí dự kiến:</lablel>
                                                        <input type="hidden" id="currencySelect" name="currency" value="vnd">
                                                        <div id="budgetInputContainer">
                                                            <input name="budget" min="1" autocomplete="budget" class="form-control mt-0" id="budgetInput" data-inputmask="'alias': 'currency', 'suffix':'₫'"/>
                                                        </div>
                                                    </div>        
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-6">
                                                        <lablel>Nhân viên phụ trách:</lablel>
                                                        <select class="form-select" id="userID" name="userID">
                                                            <option selected disabled>Chọn nhân viên phụ trách</option>                                                                                                
                                                            @foreach(App\Models\User::all() as $employee)
                                                            @if( ($employee->role !== "admin" && $employee->role !== "supervitor" && $employee->status_division == 1) || 
                                                                ($employee->divisionID == null && $employee->role !== "admin" && $employee->role !== "supervision") )
                                                                                                                        <option value="{{ $employee->id }}"> {{ $employee->name }}</option>
                                                                @endif
                                                                
                                                            @endforeach

                                                        </select>
                                                    </div>    
                                                    
                                                            
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <lablel for="note">Mô tả công việc:</lablel>
                                                        <textarea class="form-control" name="note" id="note"  rows="6"></textarea>
                                                    </div>    
                                                </div>
                                                
                                                <div class=" text-center ">
                                                    <input type="hidden" name="projectID" value="{{ $project->id }}">
                                                    <button type="submit" class="btn btn-primary px-5 mt-4" >Thêm công việc</button>
                                                </div>
                                            
                                            
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @if($project->status != 2 && $tasks->isEmpty())
                        <div class="mb-3 mt-3">

                            <a type="button" class="btn btn-outline-primary" title="Thêm công việc"  data-bs-toggle="modal" data-bs-target="#listTask">
                                <div class="d-flex"><i class="icon text-muted" data-feather="plus"></i> <span class="ms-2">Thêm danh sách công việc</span></div>
                            </a>
                                
                            <!-- add task -->
                            <div class="modal" id="listTask">
                                <div class="modal-dialog  ">
                                    <div class="modal-content">
                                
                                        <div class="modal-header">
                                            <h4 class="modal-title">Thêm danh công việc</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                                                                                                    
                                        <div class="modal-body">
                                            <form action="{{ route('task.import.khanh') }}" method="POST" enctype="multipart/form-data" id="importTaskForm">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="fileInput">Danh sách:</label>
                                                    <input type="file" name="file" class="form-control" id="fileInput">
                    
                                                </div>
                                                <input type="hidden" name="projectID" value="{{ $project->id }}">
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Thêm danh sách</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    @endif
                    </div>

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
                                <th>Chi phí</th>
                                <th></th>
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
                                    <td><div class="mt-3">{{ $task->budget }}</div></td>
                                    @if($project->status !=2)
                                    <td>
                                        <div class="d-flex">
                                            <div class="mt-2 ">

                                                <a  title="Chỉnh sửa"  href="#editTask{{ $task->id }}" data-bs-toggle="modal" data-bs-target="#editTask{{ $task->id }}" >
                                                    <i class="fa-regular fa-pen-to-square text-warning"></i>
                                                </a>
                                                    
                                                    <!-- edit task -->
                                                <div class="modal fade" id="editTask{{ $task->id }}" tabindex="-1" aria-labelledby="editProjectLabel" aria-hidden="true">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                    
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Chỉnh sửa công việc: {{ $task->task_name }}</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                                                                                                    
                                                        <div class="modal-body">
                                                            <form id="signupForm" action="{{ route('task.edit') }}" method="POST">
                                                                @csrf
                                                                <div class="row mt-4">
                                                                    <div class="col">
                                                                        <lablel for="task_name">Mã công việc:</lablel>
                                                                        <input class="form-control" value="{{ $task->task_code }}" type="text" name="task_code" id="task_code ">
                                                                    </div>    
                                                                    <div class="col">
                                                                        <lablel for="task_name">Tên công việc:</lablel>
                                                                        <input class="form-control" value="{{ $task->task_name }}" type="text" name="task_name" id="task_name">
                                                                    </div>    
                                                                </div>
                                                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                                
                                                                <div class="row mt-4">
                                                                    <div class="col">
                                                                        <lablel>Sau công việc:</lablel>
                                                                        <select class="form-select" id="parentID" name="parentID">
                                                                            <option selected disabled> Chọn công việc tiên quyết</option>
                                                                            <option value="0">Công việc đầu tiên</option>
                                                                            @foreach($tasks as $item)
                                                                                
                                                                                <option @if($item->id == $task->id) selected  @endif value="{{ $item->id }}">Sau {{ $item->task_name }}</option>
                                                                                    
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <label for="">Tiến độ(%): </label>
                                                                        <input type="number" name="progress" class="form-control" min="0" max="100" value="{{ $task->progress }}">
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="">Trạng thái</label>
                                                                        <select class="form-select" id="status" name="status">
                                                                            <option selected value="{{ $task->status }}"> @if($task->status == 0) Đang tiến hành @elseif($task->status == 1) Hoàn thành @elseif($task->status ==2) chậm tiến độ @endif</option>
                                                                            <option value="0">Đang tiến hành</option>
                                                                            <option value="1">Đã hoàn thành</option>
                                                                            <option value="2">Chậm tiến độ</option>
                                                                            <option value="3">Tạm dừng</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="row mt-4">
                                                                    <div class="col-2">
                                                                        <lablel>Ngày bắt đầu:</lablel>
                                                                        <input value="{{ $task->startDate }}" class="form-control" id="startDate" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd" placeholder="" name="startDate" required>
                                                                    </div>    
                                                                    <div class="col-2">
                                                                        <lablel>Ngày kết thúc:</lablel>
                                                                        <input value="{{ $task->endDate }}" class="form-control" id="endDate" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd" placeholder="" name="endDate" required>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="">Chi phí cũ:</label>
                                                                        <input class="form-control " type="text" value="{{ $task->budget }}" disabled name="budget_old">
                                                                    </div>
                                                                    <div class="col">
                                                                        <lablel>Chi phí dự kiến mới:</lablel>
                                                                        <input type="hidden" id="currencySelect" name="currency" value="vnd">
                                                                        <div id="budgetInputContainer">
                                                                            <input name="budget" placeholder="Nhập chi phí mới" min="1" autocomplete="budget" class="form-control mt-0 budget-mask" id="budgetInput" data-inputmask="'alias': 'currency', 'suffix':'₫'"/>
                                                                        </div>
                                                                    </div>        
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <div class="col-6">
                                                                        <lablel>Nhân viên phụ trách:</lablel>
                                                                        <select class="form-select" id="userID" name="userID">                                                                                                                
                                                                            @foreach(App\Models\User::all() as $employee)
                                                                                @if( $employee->role !== "admin" && $employee->status_division == 1)
                                                                                    <option @if($task->userID == $employee->id) selected @endif value="{{ $employee->id }}"> {{ $employee->name }}</option>
                                                                                @endif
                                                                                
                                                                            @endforeach

                                                                        </select>
                                                                    </div>    
                                                                    <input type="hidden" name="projectID" value="{{ $project->id }}">

                                                                            
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <div class="col">
                                                                        <lablel for="note">Mô tả công việc:</lablel>
                                                                        <textarea class="form-control" name="note" id="note"  rows="6" placeholder="{{ $task->note }}"></textarea>
                                                                    </div>    
                                                                </div>
                                                                
                                                                <div class=" text-center ">
                                                                    <button type="submit" class="btn btn-primary px-5 mt-4" >Chỉnh sửa</button>
                                                                </div>
                                                                

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            {{-- <div class="mt-2 mx-1">
                                                <a href="{{ route('lock.task') }}"></a>
                                                <form action="{{ route('lock.task') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                    <a class="btn btn-outline-danger">
                                                        @if($task->status==3)
                                                        <i class="icon-sm text-success" data-feather="unlock"></i>
                                                        @else
                                                        <i class="icon-sm" data-feather="lock"></i>
                                                        @endif
                                                    </a>
                                                </form>
                                            </div> --}}
                                        </div>
                                    
                                    </td>
                                    @endif
        
                                </tr>
                                
                            @endforeach
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#taskList').DataTable({
                columnDefs: [
                    { orderable: false, targets: 12 } // Chỉ định cột thứ 2 không cho phép sắp xếp
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