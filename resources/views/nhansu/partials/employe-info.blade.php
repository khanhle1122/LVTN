<section>

        
        <p class="text-center h2 mt-3">Danh sách nhân sự</p>
            

        <div class="mt-5">
            
            <div class="row mb-4">
                <span class=" col-2">Họ tên</span>    
                <span class=" col-1">Chức vụ</span>    
                <span class=" col-2">Email</span>
                <span class=" col-1">Số điện thoại</span>
                <span class=" col">Các dự án đảm nhận</span>                
                <span class=" col-1"></span>

            </div>
            
            @foreach($nhansu as $nhansu)
                
                    <div class="row mt-4  cursor-pointer" >
                        <span class="col-2 mt-2 pb-2">{{ $nhansu->name }}</span>
                        <span class="col-1 mt-2 pb-2">{{ $nhansu->position }}</span>
                        <span class="col-2 mt-2 pb-2">{{ $nhansu->email }}</span>
                        <span class="col-1 mt-2 pb-2">0{{ $nhansu->phone }}</span>
                        <span class="col">
                            <div  >
                                
                                    
                                
                                @foreach(App\models\Project::where("userID", $nhansu->id)->get() as $project)
                                        
                                    <div class="row mt-2 pb-2">
                                        <span class="col-8 text-primary">{{ $project->projectName }}</span>
                                        <span class="col-4 text-primary">@if( $project->progress  < 100)tiến độ {{ $project->progress }}% @else đã hoàn thành @endif </span>
                                    </div>
                                @endforeach
                            </div>
                        </span>
                        <span class="col-2 mt-1 ">
                            <div class="d-flex justify-content-around">
                                <div class="">
                                    <form action="{{ route('delete-user') }}" method="POST" class="">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger" value="{{ $nhansu->id }}" name="id" title="Chỉnh sửa">
                                            <i class="fa-solid fa-trash "></i>
                                        </button>
                                    </form>    
                                </div>                
                                <div class="">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#notificationModal{{ $nhansu->id }}" class="btn btn-primary" title="Thông báo">
                                        <i class="fa-solid fa-bell"></i>
                                    </a>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="notificationModal{{ $nhansu->id }}" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="notificationModalLabel">Gửi thông báo cho {{ $nhansu->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('send.notification') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ $nhansu->id }}">
                                                        <div class="form-group">
                                                            <label for="title">Tiêu đề</label>
                                                            <input type="text" class="form-control" id="title" name="title" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="content">Nội dung</label>
                                                            <textarea class="form-control" id="content" name="content" required></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary mt-2">Gửi thông báo</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editModel{{ $nhansu->id }}" class="btn btn-warning" title="Chỉnh sửa">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="editModel{{ $nhansu->id }}" tabindex="-1" aria-labelledby="editModelLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModelLabel">Chỉnh sửa <span class="h5">{{ $nhansu->name }}</span></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('edit.employe') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ $nhansu->id }}">
                                                        <div class="row mt-4">
                                                            <div class="col">
                                                                <lablel for="name">Họ và Tên </lablel>
                                                                <input type="text" id="name" class="form-control" value="{{ $nhansu->name }}" name="name" required autocomplete="name">
                                                            </div>
                                                            <div class="col">
                                                                <lablel for="usercode">Mã nhân viên</lablel>
                                                                <input type="text" id="usercode" class="form-control" value="{{ $nhansu->usercode }}" name="usercode" required autocomplete="usercode" >
                                                            </div>
                                                            <div class="col">
                                                                <label for="email">Email</label>
                                                                <input type="email" id="email" class="form-control" value="{{ $nhansu->email }}" name="email" required autocomplete="email" >
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="col">
                                                                <lablel for="address">Địa chỉ </lablel>
                                                                <input type="text" id="address" class="form-control" value="{{ $nhansu->address }}" name="address" required autocomplete="address">
                                                            </div>
                                                            <div class="col-4">
                                                                <lablel for="phone">Số điện thoại</lablel>
                                                                <input type="text" id="phone" class="form-control" value="{{ $nhansu->phone }}" name="phone" required autocomplete="phone" >
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                        <div class="row mt-4">
                                                            <div class="col">
                                                                <label for="">Chức vụ</label>
                                                                <input type="text" class="form-control" value="{{ $nhansu->position }}" name="position" required autocomplete="position" >
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
                                                        
                                                        <button type="submit" class="btn btn-primary mt-2">Chỉnh sửa</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </span>
                    </div>            
                    
            @endforeach
        </div>
        


</section>