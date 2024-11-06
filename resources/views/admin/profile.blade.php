@extends('admin.admin_dashboard')
@section('admin')
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
            <h6 class="card-title mb-2">Thông Tin</h6>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Mã nhân viên:</label>
                <p class="text-muted">{{ Auth::user()->usercode }}</p>
              </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Họ và Tên:</label>
                <p class="text-muted">{{ Auth::user()->name }}</p>
              </div>
            <div class="mt-3">
              <label class="tx-11 fw-bolder mb-0 text-uppercase">Chức vụ:</label>
              <p class="text-muted">{{ Auth::user()->position }}</p>
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
            {{-- <div class="mt-3 d-flex social-links">
              <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                <i data-feather="facebook"></i>
              </a>
              <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                <i data-feather="twitter"></i>
              </a>
              <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                <i data-feather="instagram"></i>
              </a>
            </div> --}}
          </div>
        </div>
      </div>
      <!-- left wrapper end -->
      <!-- middle wrapper start -->
      <div class="col-md col-xl middle-wrapper">
        <div class="row">
          <div class="col-md-12">
            <div class="card rounded">
              
             <div class="card-body">
              <h6 class="card-title mb-2">Chỉnh sửa thông tin</h6>
              
              <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Mã nhân viên:</label>
                <p class="text-muted">{{ Auth::user()->usercode }}</p>
              </div>
              <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Mã nhân viên:</label>
                <p class="text-muted">{{ Auth::user()->usercode }}</p>
              </div>
              <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Mã nhân viên:</label>
                <p class="text-muted">{{ Auth::user()->usercode }}</p>
              </div>
              <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Mã nhân viên:</label>
                <p class="text-muted">{{ Auth::user()->usercode }}</p>
              </div>
              <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Mã nhân viên:</label>
                <p class="text-muted">{{ Auth::user()->usercode }}</p>
              </div>
             </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>

        


@endsection