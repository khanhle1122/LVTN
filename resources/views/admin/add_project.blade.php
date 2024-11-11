@extends('admin.admin_dashboard')
@section('admin')
<!-- Trong blade layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="{{ asset('frontend/style.css') }}">

<div class="page-content ">
    
    <div class="row profile-body d-flex justify-content-center ">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-8 col-xl-7  ">
          <div class="card rounded">
            <div class="card-body">    
                <form id="signupForm" action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h3 class="h3 text-center mb-3">Thêm dự án</h3>
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
                            <div class="mb-4">
                                <label for="">Đối tác</label>
                                <input type="text" id="clientName" placeholder="Nhập tên đối tác" class="form-control" name="clientName">
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
                    <div class="row mb-4">
                        <label for="">Địa chỉ:</label>  
                        <input type="text" placeholder="Nhập địa chỉ" class="form-control" name="address">  
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
                    <div class="row mt-4">
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
</div>

<script>
    function updateFileList(input) {
    const fileCount = input.files.length;
    const fileCountElement = document.getElementById('file-count');
    fileCountElement.textContent = fileCount > 0 ? `${fileCount} files` : '0 files';

    const fileListElement = document.getElementById('file-list');
    fileListElement.innerHTML = '';

    for (let i = 0; i < fileCount; i++) {
    const fileName = input.files[i].name;
    const fileItem = document.createElement('li');
    fileItem.textContent = fileName;
    fileListElement.appendChild(fileItem);
    }
}
</script>

    
    <script>
        $(document).ready(function() {
        const currencySelect = $('#currencySelect');
        const budgetInputContainer = $('#budgetInputContainer');

        function updateBudgetInput() {
            const currency = currencySelect.val();
            const suffix = currency === 'vnd' ? '$' : '₫';
            const placeholder = currency === 'vnd' ? '' : 'Nhập số tiền (VND)';

            // Tạo input mới với data-inputmask phù hợp
            const newInput = $('<input>')
                .attr({
                    'name': 'budget',
                    'autocomplete': 'budget',
                    'class': 'form-control mt-0',
                    'id': 'budgetInput',
                    'placeholder': placeholder,
                    'data-inputmask': `'alias': 'currency', 'suffix':'${suffix}'`,
                    'min': '0' // Thêm thuộc tính min
                });

            // Thay thế input cũ bằng input mới
            budgetInputContainer.empty().append(newInput);

            // Áp dụng Inputmask cho input mới
            Inputmask({
                alias: "currency",
                suffix: suffix,
                groupSeparator: currency === 'vnd' ? ',' : '.',
                radixPoint: currency === 'vnd' ? '.' : ',',
                digits: currency === 'vnd' ? 2 : 0,
                autoUnmask: true,
                allowMinus: false, // Không cho phép số âm
                min: 0, // Giá trị tối thiểu là 0
                placeholder: "0",
                onBeforeMask: function(value, opts) {
                    // Chuyển đổi số âm thành 0 hoặc số dương
                    return value < 0 ? '0' : value;
                }
            }).mask(newInput[0]);

            // Thêm event listener để kiểm tra giá trị
            newInput.on('input', function() {
                let value = $(this).val();
                // Nếu giá trị là số âm, set về 0
                if (value < 0) {
                    $(this).val('0');
                }
            });
        }

        // Xử lý khi thay đổi loại tiền tệ
        currencySelect.on('change', updateBudgetInput);

        // Khởi tạo ban đầu
        updateBudgetInput();
    });

    </script>

@endsection