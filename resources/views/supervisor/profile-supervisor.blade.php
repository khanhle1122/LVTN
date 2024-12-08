@extends('supervisor.supervisor_dashboard')
@section('supervisor')
<!-- Trong blade layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<div class="page-content">

    
    <div class="row profile-body">
      <!-- left wrapper start -->
      <div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
        <div class="card rounded">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="card-title mb-2">Thông Tin</h6>
              </div>
              <div>
              
                                  
                <a href="#" data-bs-toggle="modal" data-bs-target="#editModel{{ Auth::user()->id }}" title="Chỉnh sửa">
                    <i class="fa-regular fa-pen-to-square text-warning"></i>
                </a>
                
                <!-- edit  -->
                <div class="modal fade" id="editModel{{ Auth::user()->id }}" tabindex="-1" aria-labelledby="editModelLabel" aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModelLabel">Chỉnh sửa  </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{ route('profile.update.supervisor') }}"  >
                                    @csrf
                                    <div class="row">
                                        
                                        
                                      <div class="mb-4">
                                          <label for="name" class="form-label">Họ và tên </label>
                                          <input value="{{ Auth::user()->name }}" type="text" id="name" class="form-control" placeholder="Nhập họ và tên" name="name" required autocomplete="name">
                                      </div>
                                  
                                  
                                      <div class="mb-3">
                                          <label for="expertise" class="form-label">Chuyên môn </label>
                                          <input type="text" id="expertise" value="{{ Auth::user()->expertise }}" class="form-control" placeholder="Nhập Chuyên môn" name="expertise" required autocomplete="expertise" >
                                      </div>
                                  
                                      <label for="phone" class="form-label">Số điện thoại</label>
                                      <input value="{{ Auth::user()->phone }}" type="text" id="phone" class="form-control mb-4 mb-md-0" data-inputmask-alias="(+99) 9999-99999 " inputmode="text" placeholder="Nhập số điện thoại" name="phone" required autocomplete="phone" >
                                
                                      <div class="mb-3">
                                          <label for="email" class="form-label">Email </label>
                                          <input value="{{ Auth::user()->email }}" type="email" id="email" class="form-control" placeholder="Nhập email" name="email" required autocomplete="email" >
                                      </div>
                                    </div>
                                    <div class="row">      
                                        <div class="col-sm">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Địa chỉ</label>
                                                <input value="{{ Auth::user()->address }}" type="text" id="address" class="form-control" placeholder="Nhập địa chỉ" name="address" required autocomplete="address">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class=" text-center ">
                                        <button type="submit" class="btn btn-primary px-5" >Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
              </div>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Mã nhân viên:</label>
                <p class="text-muted">{{ Auth::user()->usercode }}</p>
              </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Họ và Tên:</label>
                <p class="text-muted">{{ Auth::user()->name }}</p>
              </div>
            <div class="mt-3">
              <label class="tx-11 fw-bolder mb-0 text-uppercase">Chuyên môn:</label>
              <p class="text-muted">{{ Auth::user()->expertise }}</p>
            </div>
            <div class="mt-3">
              <label class="tx-11 fw-bolder mb-0 text-uppercase">Vai trò:</label>
              <p class="text-muted">
                Giám sát viên
                
              </p>
            </div>
            <div class="mt-3">
              <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
              <p class="text-muted">{{ Auth::user()->email }}</p>
            </div>
            <div class="mt-3">
              <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
              <p class="text-muted">(+84) {{ Auth::user()->phone }}</p>
            </div>
            <div class="mt-3">
              <label class="tx-11 fw-bolder mb-0 text-uppercase">address:</label>
              <p class="text-muted">{{ Auth::user()->address }}</p>
            </div>
            
          </div>
        </div>
        <div class="card rounded mt-3">
          <div class="card-body">
            @include('profile.partials.update-password-form')
          </div>
        </div>
      </div>
      <!-- left wrapper end -->
      <!-- middle wrapper start -->
      
      <div class="d-none d-md-block  col-md col-xl left-wrapper">
        <div class="card rounded h-100">
          <div class="card-body">
            <div class="">
              <div>
                <h6 class="card-title mb-2">Các dự án đảm nhận</h6>
                
              </div>
              @if($projects->isEmpty())
                  <div class="text-center mt-5">Chưa có dự án phân công</div>
                @else

              <div class="table-responsive">
                <table id="projectListTable" class="table">
                    <thead>
                    <tr>
                        <th>Mã dự án</th>
                        <th>Tên dự án</th>
                        <th>Địa điểm</th>
                        <th>Tiến độ</th>
                        <th>Trạng thái</th>
                        <th>Khởi công</th>
                        <th>Hoàn thành</th>
                        <th>Ngân sách</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $project)
                        
                            <tr>
                                
                                <td><div class="mt-2 ">{{ $project->projects->projectCode }}</div></td>
                                <td><div class="mt-2"><span class="">{{ $project->projects->projectName  }}</span></div></td>
                                <td>
                                    <div class="mt-2">{{ $project->projects->address }}</div>
                                </td>
                                <td><div class="mt-2">{{ $project->projects->progress }} %</div></td>
                                <td>
                                    <div class="mt-2">
                                        
                                    @if($project->projects->status == 1)   
                                    <span class="badge bg-success-subtle text-success border border-success d-inline-flex align-items-center">
                                        Đã hoàn thành
                                    </span>
                                    @elseif($project->projects->status == 2)
                                    <span class="badge bg-warning-subtle text-warning border border-warning d-inline-flex align-items-center">
                                        Tạm dừng
                                    </span>
                                    @elseif($project->projects->status == 0)
                                    <span class="badge bg-primary-subtle text-primary border border-primary d-inline-flex align-items-center">
                                        Đang tiến hành
                                    </span>
                                    @elseif($project->projects->status == 3)
                                    <span class="badge bg-danger-subtle text-danger border border-danger d-inline-flex align-items-center">
                                        Chậm tiến độ
                                    </span>
                                    @endif

                                    </div>
                                </td>
                                <td><div class="mt-2">{{ $project->projects->startDate }}</div></td>
                                <td><div class="mt-2">{{ $project->projects->endDate }}</div></td>
                                <td><div class="mt-2">{{ $project->projects->budget }}</div></td>
                               
                               
                            </tr>
                       



                        

                    @endforeach
                    </tbody>
                </table>
                </div>
                @endif
            </div>
            
          </div>
        </div>
      </div>
      
    </div>

        


@endsection