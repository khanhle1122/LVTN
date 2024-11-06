
    <div class="row chat-wrapper">
        <div class="col-md-12">
            <div class="">
                <div class="">

                    <div class="row position-relative">
                        <div class="col-lg chat-aside border-end-lg">
                            <div class="aside-content">
                            
                                <div class="aside-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h3 class="h3 mb-4">Danh Sách công việc cho dự án: {{ $project->projectName }}</h3>
                                                <a class="btn-toggle float-end mb-3" data-target="#tableTask">
                                                  <i class="fas fa-minus icon-sm text-dark">     </i>            
                                                </a>
                                              </div>
                                            <ul class="nav nav-tabs " role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="chats-tab" data-bs-toggle="tab" data-bs-target="#chats" role="tab" aria-controls="chats" aria-selected="true">
                                                    <div class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                        <i data-feather="table" class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                        <p class="d-none d-sm-block">Dạng bảng</p>
                                                    </div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="calls-tab" data-bs-toggle="tab" data-bs-target="#calls" role="tab" aria-controls="calls" aria-selected="false">
                                                    <div class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                        <i data-feather="pie-chart" class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                        <p class="d-none d-sm-block">dạng biểu đồ</p>
                                                    </div>
                                                    </a>
                                                </li>
                                            
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content mb-5"id="tableTask">
                                        <div class="tab-pane fade @if($show==0) show active @endif " id="chats" role="tabpanel" aria-labelledby="chats-tab">
                                            {{-- dạng bảng --}}
                                                <div class="row mb-5">
                                                    <div class="col-md-12 ">
                                                        <div class="card">
                                                            <div class="card-body ">
                                                                <h6 class="card-title ">Bảng danh Sách công việc</h6>
                                                                <div class="mb-3">
                                    
                                                                    <a type="button" class="btn btn-outline-primary" title="Thêm công việc"  data-bs-toggle="modal" data-bs-target="#myModal">
                                                                        <i class="icon text-muted" data-feather="plus"></i> Thêm công việc
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
                                                                                                    
                                                                                                    <option value="{{ $task->id }}">{{ $task->task_name }}</option>
                                                                                                        
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>    
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Thòi gian dự án</label>                                                                                        <div>
                                                                                            <div class="form-check form-check-inline">
                                                                                                <input type="radio" class="form-check-input" name="change" value="keep" id="change1" aria-invalid="false">
                                                                                                <label class="form-check-label" for="change1">
                                                                                                    Giữ nguyên thời gian của các công việc sau 
                                                                                                </label>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline">
                                                                                                <input type="radio" class="form-check-input" name="change" value="update" id="change2" aria-invalid="false">
                                                                                                <label class="form-check-label" for="change2">
                                                                                                    Thay đổi thời gian cho các công việc sau
                                                                                                </label>
                                                                                            </div>
                                                                                            
                                                                                        <label id="gender_radio-error" class="error invalid-feedback" for="gender_radio" style="display: none;"></label></div>
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
                                                                                                    @if( $employee->role === "staff")
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

                                                                <div class="table-responsive">
                                                                <table id="dataTableExample" class="table ">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>STT</th>
                                                                        <th>Tên công việc</th>
                                                                        <th>Mô tả</th>
                                                                        <th>Ngày bắt đầu</th>
                                                                        <th>Ngày hoàn thành</th>
                                                                        <th>Thời gian (ngày)</th>
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
                                                                                @php $counter++; @endphp
                                                                            <td><div class="mt-3">{{ $task->task_name }}</div></td>
                                                                            <td><div class="mt-3">{{ $task->note }}</div></td>
                                                                            <td><div class="mt-3">{{ $task->startDate }}</div></td>
                                                                            <td><div class="mt-3">{{ $task->endDate }}</div></td>
                                                                            
                                                                            <td><div class="mt-3">{{ $task->duration }} ngày</div></td>
                                                                            <td>
                                                                                <div class="mt-3">@if( $task->status == 0)
                                                                                    Đang tiến hành
                                                                                @elseif($task->status == 1)
                                                                                    Đã hoàng thành
                                                                                @else
                                                                                    Chậm tiến độ
                                                                                @endif </div>

                                                                            </td>
                                                                            <td><div class="mt-3">{{ $task->progress }} %</div></td>
                                                                            <td><div class="mt-3">{{ $task->budget }}</div></td>
                                                                            <td>
                                                                                <div class="d-flex">
                                                                                    <div class="mt-2 ">
                                    
                                                                                        <a  title="Chỉnh sửa" class="btn btn-outline-warning"  data-bs-toggle="modal" data-bs-target="#editTask{{ $task->id }}" >
                                                                                            <i class="icon-sm text-muted" data-feather="edit"></i>
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
                                                                                                                    <option value="0">Công việc đầu tiên</option>
                                                                                                                    @foreach($tasks as $item)
                                                                                                                        
                                                                                                                        <option @if($task->parentID == $item->id) selected @endif value="{{ $item->id }}">{{ $item->task_name }}</option>
                                                                                                                            
                                                                                                                    @endforeach
                                                                                                                </select>
                                                                                                            </div>    
                                                                                                            <div class="col-2">
                                                                                                                <label for="">Tiến độ(%): </label>
                                                                                                                <input type="number" name="progress" class="form-control" min="0" max="100" value="{{ $task->progress }}">
                                                                                                            </div>
                                                                                                            <div class="col">
                                                                                                                <label for="">Trạng thái</label>
                                                                                                                <select class="form-select" id="parentID" name="parentID">
                                                                                                                    <option selected value="{{ $task->status }}"> @if($task->status == 0) Đang tiến hành @elseif($task->status == 1) Hoàn thành đúng tiếng độ @elseif($task->status ==2) chậm tiến độ @endif</option>
                                                                                                                    <option value=""></option>
                                                                                                                    <option value=""></option>
                                                                                                                    <option value=""></option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="mb-3">
                                                                                                            <label class="form-label">Thòi gian dự án</label>                                                                                        <div>
                                                                                                                <div class="form-check form-check-inline">
                                                                                                                    <input type="radio" class="form-check-input" name="change" value="keep" id="change1" aria-invalid="false">
                                                                                                                    <label class="form-check-label" for="change1">
                                                                                                                        Giữ nguyên thời gian của các công việc sau 
                                                                                                                    </label>
                                                                                                                </div>
                                                                                                                <div class="form-check form-check-inline">
                                                                                                                    <input type="radio" class="form-check-input" name="change" value="update" id="change2" aria-invalid="false">
                                                                                                                    <label class="form-check-label" for="change2">
                                                                                                                        Thay đổi thời gian cho các công việc sau
                                                                                                                    </label>
                                                                                                                </div>
                                                                                                                
                                                                                                            <label id="gender_radio-error" class="error invalid-feedback" for="gender_radio" style="display: none;"></label></div>
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
                                                                                                                    @foreach(App\Models\User::all() as $employee)
                                                                                                                        @if( $employee->role === "staff")
                                                                                                                            <option @if($task->userID == $employee->id) selected @endif value="{{ $employee->id }}"> {{ $employee->name }}</option>
                                                                                                                        @endif
                                                                                                                        
                                                                                                                    @endforeach
                    
                                                                                                                </select>
                                                                                                            </div>    
                                                                                                            
                                                                                                                    
                                                                                                        </div>
                                                                                                        <div class="row mt-4">
                                                                                                            <div class="col">
                                                                                                                <lablel for="note">Mô tả công việc:</lablel>
                                                                                                                <textarea class="form-control" name="note" id="note"  rows="6" placeholder="{{ $task->note }}"></textarea>
                                                                                                            </div>    
                                                                                                        </div>
                                                                                                        
                                                                                                        <div class=" text-center ">
                                                                                                            <input type="hidden" name="projectID" value="{{ $project->id }}">
                                                                                                            <button type="submit" class="btn btn-primary px-5 mt-4" >Chỉnh sửa</button>
                                                                                                        </div>
                                                                                                        
    
                                                                                                    </form>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mt-2 mx-1">
                                                                                        <form action="{{ route('delete.task') }}" method="POST">
                                                                                            @csrf
                                                                                            @method('delete')
                                                                                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                                                            <button class="btn btn-outline-danger"><i class="icon-sm" data-feather="trash"></i></button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            
                                                                            </td>
                                                
                                                                        </tr>
                                                                        
                                                                    @endforeach
                                                                    
                                                                    </tbody>
                                                                </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="tab-pane fade mb-5 @if($show == 1 ) show active @endif " id="calls" role="tabpanel" aria-labelledby="calls-tab">
                                            {{-- dạng biểu đồ --}}
                                                
                                            <div class="row mb-5 pb-5">
                                                <div class="col-md-12">
                                                    <div class=" card">
                                                        <div class=" card-body">
                                                            <h4 class=" h4  mb-4 text-center">Biểu đồ timeline</h4>

                                                            @if(count($tasks) > 0)
                                                            <div id="content">

                                                                <ul class="timeline">
                                                                    <li class="event">
                                                                        <h3 class="title">Bắt đầu</h3>

                                                                    </li>
                                                                    @foreach($tasks as $task)
                                                                        <li class="event @if($task->status == 1) text-success @elseif($task->status == 2) text-danger @endif" data-date="{{ $task->startDate }}   {{ $task->endDate }} ">
                                                                            <div class="row">
                                                                                <div class="col row">
                                                                                    

                                                                                        <div class="col"> <h3 class="title">{{ $task->task_name }}</h3></div>
                                                                                        <div class="col-1 mt-3">
                                                                                            @if( $task->status == 1)
                                                                                            <div class="col-1">
                                                                                                <i class="icon text-success" data-feather="check"></i>
                                                                                            </div>
                                                                                            @elseif($task->status == 2)
                                                                                            <div class="col-1">
                                                                                                <i class="icon text-danger" data-feather="x"></i>
                                                                                            </div>
                                                                                            @elseif($task->status == 0)
                                                                                            <div class="col-1">
                                                                                                
                                            
                                                                                                    <a  title="Chỉnh sửa"  data-bs-toggle="modal" data-bs-target="#editTasks{{ $task->id }}" >
                                                                                                        <i class="icon-sm text-muted" data-feather="edit"></i>
                                                                                                    </a>
                                                                                                        
                                                                                                        <!-- edit task -->
                                                                                                    <div class="modal fade" id="editTasks{{ $task->id }}" tabindex="-1" aria-labelledby="editProjectLabel" aria-hidden="true">
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
                                                                                                                                <option value="0">Công việc đầu tiên</option>
                                                                                                                                @foreach($tasks as $item)
                                                                                                                                    
                                                                                                                                    <option @if($task->parentID == $item->id) selected @endif value="{{ $item->id }}">{{ $item->task_name }}</option>
                                                                                                                                        
                                                                                                                                @endforeach
                                                                                                                            </select>
                                                                                                                        </div>    
                                                                                                                        <div class="col-2">
                                                                                                                            <label for="">Tiến độ(%): </label>
                                                                                                                            <input type="number" class="form-control" min="0" max="100" value="{{ $task->progress }}">
                                                                                                                        </div>
                                                                                                                        <div class="col">
                                                                                                                            <label for="">Trạng thái</label>
                                                                                                                            <select class="form-select" id="parentID" name="parentID">
                                                                                                                                <option selected value="{{ $task->status }}"> @if($task->status == 0) Đang tiến hành @elseif($task->status == 1) Hoàn thành đúng tiếng độ @elseif($task->status ==2) chậm tiến độ @endif</option>
                                                                                                                                <option value=""></option>
                                                                                                                                <option value=""></option>
                                                                                                                                <option value=""></option>
                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="mb-3">
                                                                                                                        <label class="form-label">Thòi gian dự án</label>                                                                                        <div>
                                                                                                                            <div class="form-check form-check-inline">
                                                                                                                                <input type="radio" class="form-check-input" name="change" value="keep" id="change1" aria-invalid="false">
                                                                                                                                <label class="form-check-label" for="change1">
                                                                                                                                    Giữ nguyên thời gian của các công việc sau 
                                                                                                                                </label>
                                                                                                                            </div>
                                                                                                                            <div class="form-check form-check-inline">
                                                                                                                                <input type="radio" class="form-check-input" name="change" value="update" id="change2" aria-invalid="false">
                                                                                                                                <label class="form-check-label" for="change2">
                                                                                                                                    Thay đổi thời gian cho các công việc sau
                                                                                                                                </label>
                                                                                                                            </div>
                                                                                                                            
                                                                                                                        <label id="gender_radio-error" class="error invalid-feedback" for="gender_radio" style="display: none;"></label></div>
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
                                                                                                                                @foreach(App\Models\User::all() as $employee)
                                                                                                                                    @if( $employee->role === "staff")
                                                                                                                                        <option @if($task->userID == $employee->id) selected @endif value="{{ $employee->id }}"> {{ $employee->name }}</option>
                                                                                                                                    @endif
                                                                                                                                    
                                                                                                                                @endforeach
                                
                                                                                                                            </select>
                                                                                                                        </div>    
                                                                                                                        
                                                                                                                                
                                                                                                                    </div>
                                                                                                                    <div class="row mt-4">
                                                                                                                        <div class="col">
                                                                                                                            <lablel for="note">Mô tả công việc:</lablel>
                                                                                                                            <textarea class="form-control" name="note" id="note"  rows="6" placeholder="{{ $task->note }}"></textarea>
                                                                                                                        </div>    
                                                                                                                    </div>
                                                                                                                    
                                                                                                                    <div class=" text-center ">
                                                                                                                        <input type="hidden" name="projectID" value="{{ $project->id }}">
                                                                                                                        <button type="submit" class="btn btn-primary px-5 mt-4" >Chỉnh sửa</button>
                                                                                                                    </div>
                                                                                                                    
                
                                                                                                                </form>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    </div>
                                                                                                
                                                                                            </div>
                                                                                            @endif
                                                                                        </div>
                                                                                    
                                                                                    <div>{{ $task->note }}</div>
                                                                                    
                                                                                    <div>Thời gian hoàn thành: {{ $task->duration }}</div>
                                                                                    <div>
                                                                                        @if($task->parentID==0 )
                                                                                                    @if($task->progress<100)
                                                                                                        Tiến độ: {{ $task->progress }} % 
                                                                                                        <button data-bs-toggle="collapse" class=" btn btn-primary btn-xs" data-bs-target="#demo{{ $task->id }}"><i class="icon-sm " data-feather="upload"></i></button>
                
                                                                                                                    <div id="demo{{ $task->id }}" class="collapse row mt-2">
                                                                                                                        <form id="signupForm" action="{{ route('update.progress.task') }}" method="POST">
                                                                                                                            @csrf
                                                                                                                            <div class="col-5">
                                                                                                                                <input type="number" class="form-control form-control-sm" name="progress" value="{{ $task->progress }}" min="0" max="100"/>
                                                                                                                                <input type="hidden" name="taskID" value="{{ $task->id }}">
                                                                                                                            </div>   
                                                                                                                            <button type="submit" class="btn btn-primary mt-2" id="submitProgressUpdate">Cập nhật</button>
                                                                                                                        </form>                                                                                        
                                                                                                                    </div>
                                                                                                    @elseif($task->progress==100)
                                                                                                    Đã hoàn thành @if($task->status == 2) (chậm tiến độ) @endif
                                                                                                    @endif
                                                                                        @else
                                                                                            @foreach($tasks as $item)
                                                                                                @if($item->id == $task->parentID)
                                                                                                    
                                                                                                    
                                                                                                        
                                                                                                    @if($task->progress < 100 && $item->status == 1 || $item->status == 2 && $task->progress < 100 ) 
                                                                                                        Tiến độ: {{ $task->progress }} % 
                                                                                                        <button data-bs-toggle="collapse" class=" btn btn-primary btn-xs" data-bs-target="#demo{{ $task->id }}"><i class="icon-sm " data-feather="upload"></i></button>

                                                                                                        <div id="demo{{ $task->id }}" class="collapse row mt-2">
                                                                                                            <form id="signupForm" action="{{ route('update.progress.task') }}" method="POST">
                                                                                                                @csrf
                                                                                                                <div class="col-5">
                                                                                                                    <input type="number" class="form-control form-control-sm" name="progress" value="{{ $task->progress }}" min="{{ $task->progress }}" max="100"/>
                                                                                                                    <input type="hidden" name="taskID" value="{{ $task->id }}">
                                                                                                                </div>   
                                                                                                                <button type="submit" class="btn btn-primary mt-2" id="submitProgressUpdate">Cập nhật</button>
                                                                                                            </form>                                                                                        
                                                                                                        </div>
                                                                                                    @elseif($task->progress == 100  ) 
                                                                                                        Đã hoàn thành @if($task->status == 2) (chậm tiến độ) @endif
                                                                                                    @endif
                                                                                                    
                                                                                                @endif
                                                                                            @endforeach                                                                                    </div>
                                                                                        @endif
                                                                                </div>
                                                                                
                                                                            </div>
                                                                            
                                                                        </li>
                                                                    @endforeach
                                                                
                                                                    <li class="event ">
                                                                        <h3 class="title">Hoàn thành</h3>
                                                                        
                                                                    </li>
                                                                   
                                                                </ul>
                                                            </div>


                                                            @else 
                                                            <h5 class=" h5 text-center">Không có dữ liệu</h5>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    
        
        <script>
            $(document).ready(function() {
    const currencySelect = $('#currencySelect');
    const budgetInputContainer = $('#budgetInputContainer');

    function updateBudgetInput() {
        const currency = currencySelect.val();
        const suffix = currency === 'vnd' ? '₫' : '$';
        const placeholder = currency === 'vnd' ? 'Nhập số tiền (VND)' : 'Nhập số tiền (USD)';

        // Tạo input mới với data-inputmask phù hợp
        const newInput = $('<input>')
            .attr({
                'name': 'budget',
                'autocomplete': 'budget',
                'class': 'form-control mt-0',
                'id': 'budgetInput',
                'placeholder': placeholder,
                'data-inputmask': `'alias': 'currency', 'suffix':'${suffix}'`,
                'min': '0' // Thêm thuộc tính min
            });

        // Thay thế input cũ bằng input mới
        budgetInputContainer.empty().append(newInput);

        // Áp dụng Inputmask cho input mới
        Inputmask({
            alias: "currency",
            suffix: suffix,
            groupSeparator: currency === 'vnd' ? '.' : ',',
            radixPoint: currency === 'vnd' ? ',' : '.',
            digits: currency === 'vnd' ? 0 : 2,
            autoUnmask: true,
            allowMinus: false, // Không cho phép số âm
            min: 0, // Giá trị tối thiểu là 0
            placeholder: "0",
            onBeforeMask: function(value, opts) {
                // Chuyển đổi số âm thành 0 hoặc số dương
                return value < 0 ? '0' : value;
            }
        }).mask(newInput[0]);

        // Thêm event listener để kiểm tra giá trị
        newInput.on('input', function() {
            let value = $(this).val();
            // Nếu giá trị là số âm, set về 0
            if (value < 0) {
                $(this).val('0');
            }
        });
    }

    // Xử lý khi thay đổi loại tiền tệ
    currencySelect.on('change', updateBudgetInput);

    // Khởi tạo ban đầu
    updateBudgetInput();
});
    
        </script>
<script>
    // Thêm đoạn script này sau form
$(document).ready(function() {
    // Lấy thông tin dự án
    const projectStartDate = new Date('{{ $project->startDate }}');
    const projectEndDate = new Date('{{ $project->endDate }}');
    const projectBudget = parseFloat('{{ $project->budget }}'.replace(/[^0-9.-]+/g,"")); 
    
    // Lấy tổng chi phí đã sử dụng của các task hiện tại
    const usedBudget = parseFloat('{{ App\Models\Task::where("projectID", $project->id)->sum("budget") }}'.replace(/[^0-9.-]+/g,""));

    // Validate form sử dụng jQuery Validate
    $("#signupForm").validate({
        rules: {
            task_name: {
                required: true,
                minlength: 2
            },
            parentID: "required",
            change: "required",
            startDate: {
                required: true,
                date: true,
                validateStartDate: true
            },
            endDate: {
                required: true,
                date: true,
                validateEndDate: true
            },
            budget: {
                required: true,
            },
            userID: "required",
            progress: "required",
            note: "required"
        },
        messages: {
            task_name: {
                required: "Vui lòng nhập tên công việc",
                minlength: "Tên công việc phải có ít nhất 2 ký tự"
            },
            parentID: "Vui lòng chọn công việc tiên quyết",
            change: "Vui lòng chọn phương thức cập nhật",
            startDate: {
                required: "Vui lòng chọn ngày bắt đầu",
                date: "Ngày không hợp lệ"
            },
            endDate: {
                required: "Vui lòng chọn ngày kết thúc",
                date: "Ngày không hợp lệ"
            },
            budget: {
                required: "Vui lòng nhập chi phí",
            },
            progress:"vui lòng nhập phần trăm tiến độ"
            userID: "Vui lòng chọn nhân viên phụ trách",
            note: "Vui lòng nhập mô tả công việc"
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.addClass("invalid-feedback");
            if (element.prop("type") === "radio") {
                error.insertAfter(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        }
    });

    // Custom method để validate ngày bắt đầu
    $.validator.addMethod("validateStartDate", function(value, element) {
        const startDate = new Date(value);
        return startDate >= projectStartDate;
    }, "Ngày bắt đầu không được trước ngày bắt đầu dự án ({{ $project->startDate }})");

    // Custom method để validate ngày kết thúc
    $.validator.addMethod("validateEndDate", function(value, element) {
        const startDate = new Date($("#startDate").val());
        const endDate = new Date(value);
        return endDate <= projectEndDate && endDate >= startDate;
    }, function() {
        const startDate = new Date($("#startDate").val());
        const endDate = new Date($("#endDate").val());
        if (endDate < startDate) {
            return "Ngày kết thúc phải sau ngày bắt đầu";
        }
        return `Ngày kết thúc không được sau ngày kết thúc dự án ({{ $project->endDate }})`;
    });

    
    // Xử lý khi chọn parentID
    $("#parentID").change(function() {
        const selectedTaskId = $(this).val();
        if (selectedTaskId !== "0") {
            // Lấy thông tin task được chọn từ server
            $.ajax({
                url: `/tasks/${selectedTaskId}`,
                method: 'GET',
                success: function(response) {
                    const task = response.task;
                    // Tự động điền ngày bắt đầu sau task được chọn
                    const nextDay = new Date(task.endDate);
                    nextDay.setDate(nextDay.getDate() + 2); // Thêm 2 ngày như logic trước
                    $("#startDate").val(nextDay.toISOString().split('T')[0]);
                }
            });
        } else {
            // Nếu là task đầu tiên, set ngày bắt đầu là ngày bắt đầu dự án
            $("#startDate").val('{{ $project->startDate }}');
        }
    });
});

</script>


