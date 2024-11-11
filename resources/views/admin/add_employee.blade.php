@extends('admin.admin_dashboard')
@section('admin')
<!-- Trong blade layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<div class="page-content ">
    
    <div class="row profile-body d-flex justify-content-center ">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-8 col-xl-7  ">
          <div class="card rounded">
            <div class="card-body">    
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
                                <label for="exampleFormControlSelect1" class="form-label">Vai trò</label>
                                <select name="role" class="form-select" id="exampleFormControlSelect1">
                                    <option selected disabled>Chọn vai trò</option>
                                    <option value="admin">Quản trị viên</option>
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
</div>


@endsection