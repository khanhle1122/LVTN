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
                        <div class="col-sm-9">
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ và tên </label>
                                <input type="text" id="name" class="form-control" placeholder="Nhập họ và tên" name="name" required autocomplete="name">
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
                                <label for="exampleFormControlSelect1" class="form-label">Chức vụ</label>
                                <select name="role" class="form-select" id="exampleFormControlSelect1">
                                    <option value="admin">quản trị viên</option>
                                    <option value="supervision">Giám sát viên</option>
                                    <option value="leader">trưởng nhóm</option>
                                    <option value="staff">nhân viên</option>
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
                            <input id="password" class="form-control" name="password" type="password" placeholder="Nhập mật khẩu">
                        </div>
                        <div class="mb-3 col">
                            <label for="confirm_password" class="form-label">xác nhận mật khẩu</label>
                            <input id="confirm_password" class="form-control" name="confirm_password" type="password" placeholder="Nhập lại mật khẩu">
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
<script>
    $(document).ready(function() {
        // Khi người dùng submit form
        $("#signupForm").on('submit', function(e) {
            e.preventDefault(); // Ngăn form gửi ngay lập tức
            
            var usercode = $('#usercode').val().trim();
            var email = $('#email').val().trim();
            var name = $('#name').val().trim();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            var hasError = false;
            if (usercode === "" || email==="" || name="") {
            hasError = true;
        }




            if (hasError) {
                return; // Dừng nếu có lỗi
            }
            // Gửi AJAX để kiểm tra trùng lặp
            $.ajax({
                url: "{{ route('check.unique') }}", // Route kiểm tra
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}", // Token bảo mật
                    usercode: usercode,
                    email: email
                },
                success: function(response) {
                    // Xóa thông báo lỗi cũ
                    $("#usercode").removeClass('is-invalid');
                    $("#email").removeClass('is-invalid');
                    $(".usercode-error").remove();
                    $(".email-error").remove();
                    
                    // Kiểm tra trùng usercode
                    if (response.usercodeExists) {
                        $('#usercode').addClass('is-invalid');
                        $('#usercode').after('<div class="invalid-feedback usercode-error">Mã nhân viên đã tồn tại, vui lòng nhập mã khác</div>');
                    }

                    // Kiểm tra trùng email
                    if (response.emailExists) {
                        $('#email').addClass('is-invalid');
                        $('#email').after('<div class="invalid-feedback email-error">Email đã tồn tại, vui lòng nhập email khác</div>');
                    }

                    // Nếu không trùng, submit form
                    if (!response.usercodeExists && !response.emailExists) {
                        $('#signupForm')[0].submit(); // Submit form nếu không có lỗi
                    }
                }
            });
        });
    });
    function showError(input, message) {
        input.addClass('is-invalid');
        input.after('<div class="invalid-feedback">' + message + '</div>');
    }
</script>


@endsection