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
                <h6 class="card-title">Danh Sách dự án</h6>
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
                        <th>Loại</th>
                        <th>Tiến độ</th>
                        <th>Trạng thái</th>
                        <th>Khởi công</th>
                        <th>Hoàn thành</th>
                        <th>Quy mô</th>
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
                                <td><div class="mt-2"><a class="text-dark" href="{{ route('view.task',$project->id) }}">{{ $project->projectCode }}</a></div></td>
                                <td><div class="mt-2"><a class="text-dark" href="{{ route('view.task',$project->id) }}">{{ $project->projectName  }}</a></div></td>
                                <td>
                                    <div class="mt-2">{{ $project->address }}</div>
                                </td>
                                <td><div class="mt-2">{{ $project->user->name }}</div></td>
                                <td><div class="mt-2">{{ $project->type }}</div></td>
                                <td><div class="mt-2">{{ $project->progress }} %</div></td>
                                <td>
                                    <div class="mt-2">
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
                                </td>
                                <td><div class="mt-2">{{ $project->startDate }}</div></td>
                                <td><div class="mt-2">{{ $project->endDate }}</div></td>
                                <td><div class="mt-2">{{ $project->level }}</div></td>
                                <td><div class="mt-2">{{ $project->budget }}</div></td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <div></div>
                                        <div>

                                        </div>
                                        <div>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#editProject{{ $project->id }}" class="btn btn-outline-warning" title="Chỉnh sửa">
                                                <i class="icon-sm text-dark" data-feather="edit-2"></i>
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
                                                                    <div class="col-sm">
                                                                        <div class="mb-4">
                                                                            <label>Mã dự án</label>
                                                                            <input type="text" id="projectCode" class="form-control" placeholder="{{ $project->projectCode }}" name="projectCode" disabled value="{{ $project->projectCode }}">
                                                                            <input type="hidden" name="projectCode"  value="{{ $project->projectCode }}">
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
                                                                        <div class="mb-4">
                                                                            <label for="">Đối tác</label>
                                                                            <input type="text" class="form-control" name="clientName" placeholder="{{ $project->clientName }}" value="{{ $project->clientName }}">
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
                                                                        <textarea class="form-control" rows="5" id="description" name="description" placeholder="{{ $project->description }}" value="{{ $project->description }}"></textarea>
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
                                        <div>
                                            @if($project->status== 0 || $project->status == 1) 
                                            <a  class="btn btn-outline-danger" href="{{ route('lock.project',$project->id) }}">
                                                <i class="icon-sm text-dark" data-feather="pause"></i>
                                            </a>
                                             @elseif($project->status == 2)
                                                <a  class="btn btn-outline-success" href="{{ route('lock.project',$project->id) }}">
                                                    <i class="icon-sm text-dark" data-feather="play"></i>
                                                </a>


                                             @endif
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