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
                <h6 class="card-title">Danh Sách nhân viên</h6>
                <div class="table-responsive">
                <table id="dataTableExample" class="table">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã nhân viên</th>
                        <th>Họ Tên</th>
                        <th>chức vụ</th>
                        <th>Trạng thái</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1; @endphp
                    @foreach($employees as $employee)
                        @if($employee->role === 'admin')

                        @else
                            <tr>
                                <td>{{ $counter }}</td>
                                @php $counter++; @endphp
                                <td>{{ $employee->usercode }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>
                                    @if( $employee->role === 'staff') 
                                        nhân viên
                                    @elseif($employee->role === 'supervision' )
                                        giám sát viên
                                    @elseif($employee->role === 'leader' )
                                        nhóm trưởng
                                    @endif


                                </td>
                                <td>
                                    @if($employee->status== 0)
                                    Đang hoạt động 
                                    @elseif($employee->status == 1)
                                    Đã khoá
                                    @endif 

                                </td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ $employee->address }}</td>
                                
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <div></div>
                                        <div>            
                                         
                                            
                                            <button type="button" title="Thông tin" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#{{ $employee->usercode }}">
                                                <i class="icon-sm text-dark" data-feather="info"></i>
                                              </button>
                                              <!-- Modal -->
                                              <div class="modal fade" id="{{ $employee->usercode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Thông tin chi tiết</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                       
                                                            <h5 class="mt-3" >Các dự án dàm nhận</h5>
                                                            <div class="row my-3">
                                                            <div class="col-3">Mã dự án</div>
                                                            <div class="col-6">Ten dự án</div>
                                                            <div class="col-3">Tiến độ</div>
                                                            </div>
                                                                
    
                                                            @forelse(App\Models\Project::where('userID', $employee->id)->get() as $project)
                                                                <div class="row">
                                                                    <div class="col-3">{{ $project->projectCode }}</div>
                                                                    <div class="col-6">{{ $project->projectName }}</div>
                                                                    <div class="col-3">{{ $project->progress }}</div>
                                                                </div>
                                                            @empty
                                                                <div class="text-center">Không có dự án tham gia</div>
                                                            @endforelse
                                                       

                                                            
                                                            
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                      
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                        </div>
                                        <div class="">
                                    
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#editModel{{ $employee->id }}" class="btn btn-outline-warning" title="Chỉnh sửa">
                                                <i class="icon-sm text-dark" data-feather="edit-2"></i>
                                            </a>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="editModel{{ $employee->id }}" tabindex="-1" aria-labelledby="editModelLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModelLabel">Chỉnh sửa  <span class="h5">{{ $employee->name }}</span></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('edit.employee') }}" method="POST" >
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        <div class="mb-3">
                                                                            <label for="usercode" class="form-label">Mã nhân viên</label>
                                                                            <input value="{{ $employee->usercode }}" type="text" id="usercode" class="form-control" placeholder="Nhập mã nhân viên" name="usercode" required autocomplete="usercode" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm">
                                                                        <div class="mb-3">
                                                                            <label for="name" class="form-label">Họ và tên </label>
                                                                            <input value="{{ $employee->name }}" type="text" id="name" class="form-control" placeholder="Nhập họ và tên" name="name" required autocomplete="name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="mb-3">
                                                                            <label for="expertise" class="form-label">Chuyên môn </label>
                                                                            <input type="text" id="expertise" value="{{ $employee->expertise }}" class="form-control" placeholder="Nhập Chuyên môn" name="expertise" required autocomplete="expertise" >
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <label for="phone" class="form-label">Số điện thoại</label>
                                                                        <input value="{{ $employee->phone }}" type="text" id="phone" class="form-control mb-4 mb-md-0" data-inputmask-alias="(+99) 9999-99999 " inputmode="text" placeholder="Nhập số điện thoại" name="phone" required autocomplete="phone" >
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="mb-3">
                                                                            <label for="email" class="form-label">Email </label>
                                                                            <input value="{{ $employee->email }}" type="email" id="email" class="form-control" placeholder="Nhập email" name="email" required autocomplete="email" >
                                                                        </div>
                                                                    </div>
                                                                    {{-- <div class="col-sm-2">
                                                                        <div class="mb-3">
                                                                            <label for="password" class="form-label">Mật khẩu </label>
                                                                            <input type="text" id="password" class="form-control"  name="password" required autocomplete="password" >
                                                                        </div>
                                                                    </div> --}}
                                                                    <div class="col-sm-4">
                                                                        
                                                                        <div class="mb-3">
                                                                            <label for="exampleFormControlSelect1" class="form-label">Chức vụ</label>
                                                                            <select name="role" class="form-select" id="exampleFormControlSelect1">
                                                                                
                                                                                    @if($employee->role === 'admin')
                                                                                    <option selected  value="admin" >quản trị viên</option>
                                                                                    <option value="staff">nhân viên</option>
                                                                                    @else
                                                                                    <option selected  value="staff">nhân viên </option>
                                                                                    <option value="admin">quản trị viên</option>
                                                                                    @endif
                                                                               
                                                                               
                                                                                    
                                                                               
                                                                               
                                                                                   
                                                                                
                                                
                                                                            </select>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="row">      
                                                                    <div class="col-sm">
                                                                        <div class="mb-3">
                                                                            <label for="address" class="form-label">address</label>
                                                                            <input value="{{ $employee->address }}" type="text" id="address" class="form-control" placeholder="Nhập địa chỉ" name="address" required autocomplete="address">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class=" text-center ">
                                                                    <input type="hidden" value="{{ $employee->id }}" name="employee_id">
                                                                    <button type="submit" class="btn btn-primary px-5" >Chỉnh sửa</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($employee->status == 0)
                                            <a title="khoá nhân viên" href="{{ route('lock.employee',$employee->id) }}" class="btn btn-outline-danger"><i class="icon-sm text-dark" data-feather="lock"></i></a>
                                        @elseif($employee->status ==1 )
                                            <a title="mở khoá nhân viên" href="{{ route('lock.employee',$employee->id) }}" class="btn btn-outline-success"><i class="icon-sm text-dark" data-feather="unlock"></i></a>
                                        @endif
                                    </div>
                                </td>
                                
                            </tr>
                        @endif
                        


                        

                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
    </div>

</div>
        


@endsection