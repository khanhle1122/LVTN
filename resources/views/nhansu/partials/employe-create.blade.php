<section>
    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
        <i class="fa-solid fa-plus"></i> Thêm nhân sự 
    </button>
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDocumentModalLabel">Thêm Dự án</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="addDocumentForm" action="{{ route('store.employee') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-4">
                            <div class="col">
                                <lablel for="name">Họ và Tên </lablel>
                                <input type="text" id="name" class="form-control" placeholder="Nhập họ và tên" name="name" required autocomplete="name">
                            </div>
                            <div class="col">
                                <lablel for="usercode">Mã nhân viên</lablel>
                                <input type="text" id="usercode" class="form-control" placeholder="Nhập mã nhân viên" name="usercode" required autocomplete="usercode" >
                            </div>
                            <div class="col">
                                <label for="email">email</label>
                                <input type="email" id="email" class="form-control" placeholder="Nhập email" name="email" required autocomplete="email" >
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <lablel for="address">Địa chỉ </lablel>
                                <input type="text" id="address" class="form-control" placeholder="Nhập địa chỉ" name="address" required autocomplete="address">
                            </div>
                            <div class="col-4">
                                <lablel for="phone">nhập số điện thoại</lablel>
                                <input type="text" id="phone" class="form-control" placeholder="Nhập số điện thoại" name="phone" required autocomplete="phone" >
                            </div>
                            
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col">
                                <label for="">Chức vụ</label>
                                <input type="text" class="form-control" placeholder="Nhập chức vụ" name="position" required autocomplete="position" >
                            </div>
                            <div class="col">
                                <lablel>Quyền truy cập</lablel>
                                <select class="form-select" name="role">
                                    <option>Toàn quyền</option>
                                    <option>Giám sát</option>
                                    <option>Nhân viên</option>
                                  </select>
                            </div>
                            
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <label for="password">Mật khẩu</label>
                                <input id="password" type="password" class="form-control" placeholder="Nhập mật khẩu" name="password" required autocomplete="new-password" >

                            </div>
                            <div class="col">
                                <label for="password_confirmation">Xác nhận lại mật khẩu</label>
                                <input id="password_confirmation" type="password" class="form-control" placeholder="Nhập lại mật khẩu" name="password_confirmation" required autocomplete="new-password" >

                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit"  class="btn btn-primary">Thêm nhân viên</button>
                        </div>
                        
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    
</section>