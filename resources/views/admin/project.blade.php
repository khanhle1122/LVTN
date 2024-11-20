@extends('admin.admin_dashboard')
@section('admin')
<!-- Trong blade layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>	
<div class="page-content">

    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <h3 class="mb-3 h3">Danh Sách dự án</h3>
                <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i data-feather="plus" class="icon "></i>
                    <span>Thêm dự án</span>
                  </button>
                  <!-- Thêm dự án -->
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Thêm dự án</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="signupForm" action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="mb-4">
                                            <label>Mã dự án</label>
                                            <input type="text" id="projectCode" class="form-control" placeholder="nhập mã dự án"  name="projectCode" required>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-4">
                                            <label for="name">Tên dự án</label>
                                            <input type="text" class="form-control"  placeholder="nhập tên dự án"  name="projectName" id="projectName" autocomplete="projectName">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label for="clientID" class="form-label">Đối tác</label>
                                            <select class="form-select" name="clientID" id="clientID">
                                                <option selected disabled>Chọn đối tác</option>
                                                @foreach($contractors as $contractor)
                                                <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
            
            
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <lablel>Loại công trình</lablel>
                                            <select class="form-select" id="type" name="type">
                                                <option selected disabled >Chọn loại công trình</option>
            
                                                <option >Công trình dân dụng</option>
                                                <option >Công trình công nghiệp</option>
                                                <option >Công trình hạ tâng - giao thông</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row ">
                                    <div class="mb-4 col">
                                        <label for="">Địa chỉ:</label>  
                                    <input type="text" placeholder="Nhập địa chỉ" class="form-control" name="address">  
                                    </div>
                                </div>   
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <lablel>Người giám sát</lablel>
                                            <select class="form-select" id="userID" name="userID">
                                                <option selected disabled>Chọn người giám sát</option>
                                                @foreach(App\Models\User::all() as $user)
                                                    @if($user->role !== 'staff')
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                       
                                    </div>
                                    <div class="col-sm row mb-0">
                                        <div class="mb-4  col">
                                            <lablel>Ngày bắt đầu</lablel>
                                            <input  class="form-control" id="startDate" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd" placeholder="" name="startDate" required>
                                        </div>
                                        <div class="mb-4 col">
                                            <label for="">Ngày kết thúc</label>
                                            <input  class="form-control" id="endDate" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd" placeholder="" name="endDate" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row " >
                                    
                                    <div class="col-sm-5">
                                        <div class="mb-4 mt-2">
                                            <lablel>Quy mô dự án</lablel>
                                            <select class="form-select" id="level" name="level">
                                                <option selected disabled>Quy mô dự án</option>
                                                <option>Nhỏ</option>
                                                <option>Trung bình</option>
                                                <option>Lớn</option>
            
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-5">
                                        <div class="mb-4">
                                            <label class="form-label">Ngân sách:</label>
                                            <div id="budgetInputContainer">
                                                <input name="budget" min="1" autocomplete="budget" class="form-control mt-0" id="budgetInput" data-inputmask="'alias': 'currency', 'suffix':'₫'"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div>Các tài liệu liên quan</div>
                                    <label class="custom-file-input">
                                        <input type="file" multiple onchange="updateFileList(this)" name="files[]"/>
                                        <span id="file-count"></span>
                                        <div class="file-info">
                                          
                                          <ul class="file-list" id="file-list"></ul>
                                        </div>
                                    </label>
                                </div>
            
            
                                <div class="row mt-3">
                                    <div class="mb-3 col">
                                        <label for="description">Mô tả dự án:</label>
                                        <textarea class="form-control" placeholder="nhập mô tả dự án" rows="5" id="description" name="description" ></textarea>
                                    </div>
                                </div>
                                <div class=" text-center ">
                                    <button type="submit" class="btn btn-primary px-5" >Thêm dự án</button>
                                </div>
                            </form>



                        </div>
                        
                      </div>
                    </div>
                  </div>


                <div class="table-responsive">
                <table id="dataTableExample" class="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>STT</th>
                        <th>Mã dự án</th>
                        <th>Tên dự án</th>
                        <th>Địa điểm</th>
                        <th>Người giám sát</th>
                        <th>Tiến độ</th>
                        <th>Trạng thái</th>
                        <th>Khởi công</th>
                        <th>Hoàn thành</th>
                        <th>Ngân sách</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $project)
                        
                            <tr>
                                <td>                                            
                                    <a href="{{ route('project.toggleStar',$project->id) }}" class="d-flex flex-row-reverse mt-2" > @if( $project->toggleStar == 1) <i class="fa-solid fa-star" style="color: #FFD43B;"></i> @else <i class="fa-regular fa-star" ></i>  @endif </a>                                    
                                </td>
                                <td ><div class="mt-2">{{ $loop->iteration }}</div></td>
                                <td><div class="mt-2"><a class="" href="{{ route('view.task',$project->id) }}">{{ $project->projectCode }}</a></div></td>
                                <td><div class="mt-2"><span class="">{{ $project->projectName  }}</span></div></td>
                                <td>
                                    <div class="mt-2">{{ $project->address }}</div>
                                </td>
                                <td><div class="mt-2">{{ $project->user->name }}</div></td>
                                <td><div class="mt-2">{{ $project->progress }} %</div></td>
                                <td>
                                    <div class="mt-2">
                                        
                                    @if($project->status == 1)   
                                    <span class="badge bg-success-subtle text-success border border-success d-inline-flex align-items-center">
                                        <i data-feather="check-circle" class="icon-sm me-1"></i>
                                        Đã hoàn thành
                                    </span>
                                    @elseif($project->status == 2)
                                    <span class="badge bg-warning-subtle text-warning border border-warning d-inline-flex align-items-center">
                                        <i data-feather="pause-circle" class="icon-sm me-1"></i>
                                        Tạm dừng
                                    </span>
                                    @elseif($project->status == 0)
                                    <span class="badge bg-primary-subtle text-primary border border-primary d-inline-flex align-items-center">
                                        <i data-feather="play-circle" class="icon-sm me-1"></i>
                                        Đang tiến hành
                                    </span>
                                    @elseif($project->status == 3)
                                    <span class="badge bg-danger-subtle text-danger border border-danger d-inline-flex align-items-center">
                                        <i data-feather="alert-circle" class="icon-sm me-1"></i>
                                        Chậm tiến độ
                                    </span>
                                    @endif

                                    </div>
                                </td>
                                <td><div class="mt-2">{{ $project->startDate }}</div></td>
                                <td><div class="mt-2">{{ $project->endDate }}</div></td>
                                <td><div class="mt-2">{{ $project->budget }}</div></td>
                                <td>
                                    <div class="d-flex justify-content-between mt-2">
                                        
                                        <div class="me-1">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#editProject{{ $project->id }}" title="Chỉnh sửa">
                                                <i class="icon-sm text-warning" data-feather="edit-2"></i>
                                            </a>
                                            
                                            <!-- Modal edit -->
                                            <div class="modal fade" id="editProject{{ $project->id }}" tabindex="-1" aria-labelledby="editProjectLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editProjectLabel">Chỉnh sửa <span class="h5">{{ $project->projectName }}</span></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="signupForm" action="{{ route('edit.project',$project->id) }}" method="POST">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        <div class="mb-4">
                                                                            <label>Mã dự án</label>
                                                                            <input type="text" id="projectCode" class="form-control" placeholder="{{ $project->projectCode }}" name="projectCode"  value="{{ $project->projectCode }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm">
                                                                        <div class="mb-4">
                                                                            <label for="name">Tên dự án</label>
                                                                            <input type="text" class="form-control" placeholder="{{ $project->projectName }}" value="{{ $project->projectName }}" name="projectName" id="projectName" autocomplete="projectName">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm">
                                                                        <div class="mb-3">
                                                                            <label for="clientID" class="form-label">Đối tác</label>
                                                                            <select class="form-select" name="clientID" id="clientID">
                                                                                @foreach($contractors as $contractor)
                                                                                <option @if($contractor->id == $project->clientID) selected @endif value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                                            
                                            
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="mb-4">
                                                                            <lablel>Loại công trình</lablel>
                                                                            <select class="form-select" id="type" name="type">
                                                                                <option value="{{ $project->type }}">{{ $project->type }}</option>
                                                                                <option disabled>loại công trình:</option>
                                            
                                                                                <option >Công trình dân dụng</option>
                                                                                <option >Công trình nhà nước</option>
                                                                                <option >Công trình công nghiệp</option>
                                                                                <option >Công trình hạ tâng - giao thông</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                                <div class="row">
                                                                    <div class="mb-4">
                                                                        <label for="">Địa chỉ</label>
                                                                        <input type="text" name="address" class="form-control" value="{{ $project->address }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="mb-4">
                                                                            <lablel>Người giám sát</lablel>
                                                                            <select class="form-select" id="sel1" name="userID">
                                                                                <option  value="{{ $project->user->id }}">{{ $project->user->name }}</option>
                                                                                <option disabled>Người khác:</option>

                                                                                @foreach(App\Models\User::all() as $user)
                                                                                    @if($user->role === 'supervision' && $project->userID != $user->id)
                                                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        
                                                                       
                                                                    </div>
                                                                    <div class="col-sm row mb-0">
                                                                        <div class="mb-4  col">
                                                                            <lablel>Khởi công</lablel>
                                                                            <input  class="form-control" id="startDate" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy/mm/dd" placeholder="" value="{{ $project->startDate }}" name="startDate">
                                                                        </div>
                                                                        <div class="mb-4 col">
                                                                            <label for="">Hoàn thành</label>
                                                                            <input  class="form-control" id="endDate" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy/mm/dd" placeholder="" value="{{ $project->endDate }}" name="endDate">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row " >
                                                                    
                                                                    <div class="col-sm-5">
                                                                        <div class="mb-4 mt-2">
                                                                            <lablel>Quy mô dự án</lablel>
                                                                            <select class="form-select" id="level" name="level">
                                                                                <option>Nhỏ</option>
                                                                                <option>Trung bình</option>
                                                                                <option>Lớn</option>
                                            
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="mb-4">
                                                                            <label class="form-label">Ngân sách cũ:</label>
                                                                            <div >
                                                                                <input type="text" class="form-control mt-0" value="{{ $project->budget }}" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="mb-4">
                                                                            <label class="form-label">Loại tiền tệ:</label>
                                                                            <select class="form-select" id="currencySelect{{ $project->id }}" name="currency">
                                                                                <option value="vnd">VND</option>
                                                                                <option value="usd">USD</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <div class="mb-4">
                                                                            <label class="form-label">Ngân sách mới:</label>
                                                                            <div id="budgetInputContainer{{ $project->id }}">
                                                                                <input name="budget" value="0" autocomplete="budget" class="form-control mt-0" id="budgetInput{{ $project->id }}" data-inputmask="'alias': 'currency', 'suffix':'₫'"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col">
                                                                        <label for="description">Mô tả dự án:</label>
                                                                        <textarea class="form-control" rows="5" id="description" name="description"  value="{{ $project->description }}"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class=" text-center ">
                                                                    <button type="submit" class="btn btn-primary px-5" >Sửa </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <span class="mx-1">|</span>

                                            @if($project->status== 0 || $project->status == 1 || $project->status == 3) 
                                            
                                            <a class=""   href="{{ route('lock.project',$project->id) }}">
                                                <i class="icon-sm text-danger" data-feather="lock"></i>
                                            </a>
                                             @elseif($project->status == 2)
                                                <a  class="" href="{{ route('lock.project',$project->id) }}">
                                                    <i class="icon-sm text-success" data-feather="unlock"></i>
                                                </a>


                                             @endif
                                        </div>
                                        <div class="">
                                            <span class="mx-1">|</span>
                                            <a  class="" href="{{ route('view.task',$project->id) }}">
                                                <i class="icon-sm text-primary" data-feather="eye"></i>
                                            </a>
                                            
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
        <script>
			$(document).ready(function() {
    // Xử lý khi modal được hiển thị
    $('div[id^="editProject"]').on('shown.bs.modal', function (e) {
        const projectID = $(this).attr('id').replace('editProject', ''); // Lấy id của project
        const currencySelect = $(`#currencySelect${projectID}`);
        const budgetInputContainer = $(`#budgetInputContainer${projectID}`);

        function updateBudgetInput() {
            const currency = currencySelect.val();
            const suffix = currency === 'vnd' ? '₫' : '$';
            const placeholder = currency === 'vnd' ? 'Nhập số tiền (VND)' : 'Nhập số tiền (USD)';

            // Tạo input mới với data-inputmask phù hợp
            const newInput = $('<input>')
                .attr({
                    'name': 'budget',
                    'autocomplete': 'budget',
                    'class': 'form-control ',
                    'id': `budgetInput${projectID}`,
                    'placeholder': placeholder,
                    'data-inputmask': `'alias': 'currency', 'suffix':'${suffix}'`
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
                autoUnmask: true
            }).mask(newInput[0]);
        }

        // Khởi tạo khi modal hiển thị và khi thay đổi loại tiền tệ
        updateBudgetInput();
        currencySelect.on('change', updateBudgetInput);
    });
});


	
		</script>


@endsection