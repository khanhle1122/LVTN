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
                <h3 class="h3">Danh Sách nhân viên</h3>

                <!-- Button add employee modal -->
                <button type="button" class="btn btn-outline-primary my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="" data-feather="plus"></i>
                    <span>Thêm nhân viên</span>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('store.employee') }}" method="POST" id="signupForm">
                                @csrf
                                <h3 class="h3 text-center mb-3">Thêm Nhân viên</h3>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="usercode" class="form-label">Mã nhân viên</label>
                                            <input type="text" id="usercode" class="form-control" placeholder="Nhập mã nhân viên" name="usercode" required autocomplete="usercode" >
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Họ và tên </label>
                                            <input type="text" id="name" class="form-control" placeholder="Nhập họ và tên" name="name" required autocomplete="name">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="expertise" class="form-label">Chuyên môn </label>
                                            <input type="text" id="expertise" class="form-control" placeholder="Nhập Chuyên môn" name="expertise" required autocomplete="expertise" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="text" id="phone" class="form-control mb-4 mb-md-0" data-inputmask-alias="(+99) 9999-99999 " inputmode="text" placeholder="Nhập số điện thoại" name="phone" required autocomplete="phone" >
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email </label>
                                            <input type="email" id="email" class="form-control" placeholder="Nhập email" name="email" required autocomplete="email" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                    
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Vai trò</label>
                                            <select name="role" class="form-select" id="role">
                                                <option selected disabled>Chọn vai trò</option>
                                                <option value="admin">Quản trị viên</option>
                                                <option value="supervision">Giám sát</option>
                                                <option value="leader">Nhóm trưởng</option>
                                                <option value="staff">Nhân viên</option>
            
                                            </select>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                <div class="row">      
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">address</label>
                                            <input type="text" id="address" class="form-control" placeholder="Nhập địa chỉ" name="address" required autocomplete="address">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="mb-3 col">
                                        <label for="password" class="form-label">mật khẩu</label>
                                        <input id="password" class="form-control" name="password" type="text" placeholder="Nhập mật khẩu">
                                    </div>
                                   
                                </div>
                                <div class=" text-center ">
                                    <button type="submit" class="btn btn-primary px-5" >Thêm nhân viên</button>
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
                        <th>STT</th>
                        <th>Mã nhân viên</th>
                        <th>Họ Tên</th>
                        <th>Vai trò</th>
                        <th>Chuyên môn</th>
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
                        <tr>
                            <td><div class="mt-2">{{ $counter }}</div></td>
                            @php $counter++; @endphp
                            <td><div class="mt-2">{{ $employee->usercode }}</div></td>
                            <td><div class="mt-2">{{ $employee->name }}</div></td>
                            <td>
                                Quản trị viên


                            </td>
                            <td><div class="mt-2">{{ $employee->expertise }}</div></td>
                            <td>
                               <div class="mt-2"> @if($employee->status== 0)
                                <span class="badge bg-success">Hoạt động</span>
                                @elseif($employee->status == 1)
                                <span class="badge bg-danger">Đã khoá</span>

                                @endif </div>

                            </td>
                            <td><div class="mt-2">{{ $employee->email }}</div></td>
                            <td><div class="mt-2">{{ $employee->phone }}</div></td>
                            <td><div class="mt-2">{{ $employee->address }}</div></td>
                            
                            <td>
                               
                            </td>
                            
                        </tr>
                        @else
                            <tr>
                                <td><div class="mt-2">{{ $counter }}</div></td>
                            @php $counter++; @endphp
                            <td><div class="mt-2">{{ $employee->usercode }}</div></td>
                            <td><div class="mt-2">{{ $employee->name }}</div></td>
                                <td>
                                   <div class="mt-2">
                                    @if( $employee->role === 'staff') 
                                        nhân viên
                                    @elseif($employee->role === 'supervision' )
                                        giám sát viên
                                    @elseif($employee->role === 'leader' )
                                        nhóm trưởng
                                        
                                    @endif

                                   </div>

                                </td>
                                <td><div class="mt-2">{{ $employee->expertise }}</div></td>
                            <td>
                               <div class="mt-2"> @if($employee->status== 0)
                                <span class="badge bg-success">Hoạt động</span>
                                @elseif($employee->status == 1)
                                <span class="badge bg-danger">Đã khoá</span>

                                @endif </div>

                            </td>
                            <td><div class="mt-2">{{ $employee->email }}</div></td>
                            <td><div class="mt-2">{{ $employee->phone }}</div></td>
                            <td><div class="mt-2">{{ $employee->address }}</div></td>
                            
                                <td>
                                    <div class="d-flex justify-content-between mt-2">
                                        <div></div>
                                        <div>    
                                            <a type="button" title="Thông tin"  data-bs-toggle="modal" data-bs-target="#{{ $employee->usercode }}">
                                                <i class="icon-sm text-primary" data-feather="info"></i>
                                              </a>
                                              <!-- Modal -->
                                              <div class="modal fade" id="{{ $employee->usercode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Thông tin dự án đảm nhận</h5>
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
                                                                    @if($project->status==1)
                                                                        <div class="col-6">{{ $project->projectName }}</div>
                                                                    @elseif($project->progress <100)
                                                                        <div class="col-3">{{ $project->progress }}</div>
                                                                    @endif
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
                                        <span class="mx-1">|</span>
                                        <div class="">
                                    
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#editModel{{ $employee->id }}" title="Chỉnh sửa">
                                                <i class="icon-sm text-warning" data-feather="edit-2"></i>
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
                                                                    
                                                                    <div class="col-sm-4">
                                                                        
                                                                        <div class="mb-3">
                                                                            <label for="exampleFormControlSelect1" class="form-label">Vai trò</label>
                                                                            <select name="role" class="form-select" id="exampleFormControlSelect1">
                                                                                
                                                                                   
                                                                                    <option  @if($employee->role === 'admin') selected @endif value="admin" >Quản trị viên</option>
                                                                                    <option  @if($employee->role === 'supervision') selected @endif value="supervisor">Giám sát</option>
                                                                                    <option  @if($employee->role === 'leader') selected @endif value="leader">Nhóm trưởng</option>
                                                                                    <option  @if($employee->role === 'staff') selected @endif value="staff">Nhân viên</option>
                                                                                    
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
                                        <span class="mx-1">|</span>
                                        @if($employee->status == 0)
                                            <a title="khoá nhân viên" href="{{ route('lock.employee',$employee->id) }}" ><i class="icon-sm text-danger" data-feather="lock"></i></a>
                                        @elseif($employee->status ==1 )
                                            <a title="mở khoá nhân viên" href="{{ route('lock.employee',$employee->id) }}" ><i class="icon-sm text-success" data-feather="unlock"></i></a>
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