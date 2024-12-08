@extends('leader.leader_dashboard')
@section('leader')
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
                                <form method="post" action="{{ route('profile.update.leader') }}"  >
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
                                                <label for="address" class="form-label">address</label>
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
                @if(Auth::user()->role === "leader")
                 Trưởng nhóm
                @endif
                
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
                <h6 class="card-title mb-2">Thông Tin các thành viên trong nhóm</h6>
              </div>
              @if(Auth::user()->divisionID == null)

              <div class="text-center mt-5">Chưa có công việc đảm nhận</div>
              @else
              <div class="h6">{{ Auth::user()->divisions->divisionName }}</div>
              <div class="row">
                <div class="col-3 my-3">Mã nhân viên</div>
                <div class="col-4 my-3">Tên nhân viên</div>
                <div class="col-2 my-3">Vai trò</div>
                <div class="col-3 my-3">Email</div>
              </div>
              @if($userClass->isNotEmpty())
              <div class="row">
                @foreach($userClass as $user)
                  <div class="col-3 my-3">{{ $user->usercode }}</div>
                  <div class="col-4 my-3">{{ $user->name }} @if($user->id == Auth()->id()) (Bạn ) @endif</div>
                  <div class="col-2 my-3">@if($user->status_division == 1) Trưởng nhóm @else thành viên @endif</div>
                  <div class="col-3 my-3" >{{ $user->email }}</div>
                @endforeach
              </div>
              @else
              <div>bạn chưa được phân công vào nhóm</div>
              @endif
              @endif
            </div>
            
          </div>
        </div>
      </div>
      
    </div>

        


@endsection