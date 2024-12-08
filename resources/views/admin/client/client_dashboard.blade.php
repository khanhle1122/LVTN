@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

    <div class="row ">
        <!-- left wrapper start -->
        
       
        
        <div class="col-md-12 col-xl-12  middle-wrapper">
            <div class="card rounded">
                <div class="card-body"> 
                    <h3 class="mb-3">Danh sách Các gói thầu</h3>
                    <button type="button" class="btn btn-outline-primary my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="" data-feather="plus"></i>
                        <span>Thêm đối tác</span>
                    </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm đối tác</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="mt-3" action="{{ route('add.client') }}"  method="POST" id="signupForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name">Tên đối tác</label>
                                        <input class="form-control" type="text" name="name" id="name">
                                    </div>
                                    <div class="mb-3">
                                      <label for="">Mã đối tác</label>
                                      <input type="text" name="contactorCode" id="contactorCode" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">email</label>
                                        <input class="form-control" type="text" name="email" id="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Số điện thoại</label>
                                        <input  class="form-control" name="phone" id="phone" data-inputmask-alias="(+99) 9999-9999">                      </div>
                                    <div class="mb-3">
                                        <label for="">Địa chỉ</label>
                                        <input class="form-control" type="text" name="address" id="address">
                                    </div>
                                    
                                    <input type="hidden" name="role" value="contractor">
                                    <div class="text-center"><button class="btn btn-primary" type="submit">Thêm</button></div>
                                </form>
                            </div>
                            
                        </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary my-3" data-bs-toggle="modal" data-bs-target="#addListEmployee">
                        <i class="" data-feather="plus"></i>
                        <span>Thêm danh sách đối tác</span>
                    </button>
    
                    <div class="modal fade" id="addListEmployee" tabindex="-1" aria-labelledby="addListEmployeeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="addListEmployeeLabel">Thêm danh sách đối tác</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                            </div>
                            <div class="modal-body">
                                
                                <form action="{{ route('client.import.khanh') }}" method="POST" enctype="multipart/form-data" id="importForm">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="fileInput">Danh sách:</label>
                                        <input type="file" name="file" class="form-control" id="fileInput">
                                        <!-- Invalid feedback sẽ được thêm vào đây bằng JS -->
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Thêm danh sách</button>
                                    </div>
                                </form>
                            
                            </div>
                            
                        </div>
                        </div>
                    </div>
                  <div class="table-responsive">
                    <table id="contractTable" class="table">
                        <thead>
                        <tr>
                            <th>Tên đối tác</th>
                            <th>Mã đối tác</th>
                            <th>email</th>
                            <th>số điẹn thoại</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>  
                            @foreach($contactors as $client)
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->contactorCode }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>{{ $client->address }}</td>
                                    <td>@if($client->status==0) Đang đấu thầu @else Đã thầu @endif</td>
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <a href="#exampleModal{{ $client->id }}"  data-bs-toggle="modal" data-bs-target="#exampleModal{{ $client->id }}">
                                                    <i class="icon-sm text-warning" data-feather="edit-2"></i>
                                                  </a>
                                                  <div class="modal fade" id="exampleModal{{ $client->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa đối tác</h5>
                                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="mt-3" action="{{ route('edit.client') }}"  method="POST" id="signupForm">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="name">Tên đối tác</label>
                                                                    <input class="form-control" type="text" name="name" id="name" value="{{ $client->name }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Mã đối tác</label>
                                                                    <input type="text" name="contactorCode" id="contactorCode" class="form-control" value="{{ $client->contactorCode }}">
                                                                  </div>
                                                                <div class="mb-3">
                                                                    <label for="email">email</label>
                                                                    <input class="form-control" type="email" name="email" id="email" value="{{ $client->email }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Số điện thoại</label>
                                                                    <input class="form-control" type="text" name="phone" id="phone" value="{{ $client->phone }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Địa chỉ</label>
                                                                    <input class="form-control" type="text" name="address" id="address" value="{{ $client->address }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlSelect1" class="form-label">Trạng thái</label>
                                                                    <select class="form-select" id="exampleFormControlSelect1" name="status">
                                                                        <option @if($client->status == 0) selected @endif value="0">Đang đấu thầu</option>
                                                                        <option @if($client->status == 1) selected @endif value="1">Đã thầu</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <input type="hidden" name="id" value="{{ $client->id }}">
                                                                <div class="text-center"><button class="btn btn-primary" type="submit">Thêm</button></div>
                                                            </form>
                                                        </div>
                                                        
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>
                                            <div class="ms-3">            
                                                <a title="Thông tin" href="#{{ $client->id }}" data-bs-toggle="modal" data-bs-target="#modal-{{ $client->id }}">
                                                    <i class="icon-sm text-dark" data-feather="info"></i>
                                                </a>
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="modal-{{ $client->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Thông tin chi tiết</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <p><strong>Tên đối tác:</strong> {{ $client->name }}</p>
                                                                        <p><strong>Email:</strong> {{ $client->email }}</p>
                                                                        <p><strong>Số điện thoại:</strong> {{ $client->phone }}</p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p><strong>Địa chỉ:</strong> {{ $client->address }}</p>
                                                                        <p><strong>Trạng thái:</strong> 
                                                                            @if($client->status == 0)
                                                                                <span class="">Đang đấu thầu</span>
                                                                            @else
                                                                                <span class="">Đã Thầu</span>
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-3">
                                                                    <div class="col-12">
                                                                        <h6>Các dự án hợp các:</h6>

                                                                        <div class="row">
                                                                            <div class="col-3">Mã dự án</div>
                                                                            <div class="col-6">Tên dự án</div>
                                                                            <div class="col-3">Tiến độ</div>
                                                                        </div>
                                                                        @foreach($projects as $project)
                                                                            @if($project->clientID == $client->id) 
                                                                            <div class="row">
                                                                                <div class="col-3"><a href="{{ route('view.task',$project->id) }}">{{ $project->projectCode }}</a> </div>
                                                                                <div class="col-6"><a href="{{ route('view.task',$project->id) }}">{{ $project->projectName }}</a> </div>
                                                                                <div class="col-3">{{ $project->progress }} %</div>
                                                                            </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
       
        $('#contractTable').DataTable({
            columnDefs: [
                    { orderable: false, targets: 6 } // Chỉ định cột thứ 2 không cho phép sắp xếp
                ]
        });
    });
    </script>
    <script>
        $(document).ready(function() {
            $('#importForm').on('submit', function(e) {
                e.preventDefault();
                
                // Reset các thông báo lỗi cũ
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                
                const fileInput = $('#fileInput');
                const file = fileInput[0].files[0];
                const maxSize = 8 * 1024 * 1024; // 8MB
                let hasError = false;
                
                // Kiểm tra file có được chọn không
                if (!file) {
                    showError(fileInput, 'Vui lòng chọn file');
                    hasError = true;
                    return;
                }
                
                // Kiểm tra định dạng file
                const fileExtension = file.name.split('.').pop().toLowerCase();
                if (!['xlsx', 'xls', 'csv'].includes(fileExtension)) {
                    showError(fileInput, 'File phải có định dạng .xlsx, .xls hoặc .csv');
                    hasError = true;
                    return;
                }
                
                // Kiểm tra kích thước file
                if (file.size > maxSize) {
                    showError(fileInput, 'Kích thước file không được vượt quá 8MB');
                    hasError = true;
                    return;
                }
                
                // Nếu không có lỗi thì submit form
                if (!hasError) {
                    this.submit();
                }
            });
        
            // Hàm hiển thị lỗi
            function showError(element, message) {
                element.addClass('is-invalid');
                element.after(`<div class="invalid-feedback">${message}</div>`);
            }
        
            // Reset lỗi khi chọn file mới
            $('#fileInput').on('change', function() {
                $(this).removeClass('is-invalid');
                $('.invalid-feedback').remove();
            });
        });
        </script>
@endsection