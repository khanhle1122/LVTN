<section>
    <div class="">
        <h3 class="h3">Chi tiết dự án</h3>
        <a href="{{ route('project.toggleStar',$project->id) }}" class="d-flex flex-row-reverse mt-0" > @if( $project->status == 1) <i class="fa-solid fa-star" style="color: #FFD43B;"></i> @else <i class="fa-regular fa-star" ></i>  @endif </a>
        
        <div class="d-flex">
            <div class="circle" style="background: conic-gradient(rgb(49, 164, 7) {{$project->progress}}%, #e0e0e0 0)">
                <span class="percentage">{{ $project->progress }}%</span>
            </div>
            <div>
                <div class="">Mã: {{ $project->projectCode }}</div>
                <div class="">Tên: {{ $project->projectName }}</div>
                <div class="">Quy mô: {{ $project->level }}</div>
                <div class="">Thời gian dự án: <div class="date-container"  data-start-date= "{{ $project->startDate }}" data-end-date= "{{ $project->endDate }}"></div></div>
                <div class="">Đối tác: {{ $project->clientName }}</div>
                <div class="">Ghi chú:{{ $project->description }}</div>
            </div>
        </div>
    </div>
    <div class="mt-5 border">
        <h3 class="h3 py-2 ps-2 bg-dark text-center text-white">Thư mục dự án</h3>
        <div class=" p-2">
            <div class="d-flex justify-content-between">
                <div class="d-flex ">
                    <i class="fa-solid fa-folder mt-1 me-2"></i>
                    <button type="button" id="toggle-icon" class="" data-bs-toggle="collapse" data-bs-target="#{{ $project->document->id }}">{{ $project->document->documentName }} <i class="fa-solid fa-angle-down"></i></button>
                    
                </div>
                <div class=" d-flex justify-content-between">
                    
                    <div>
                        <button type="button" class="" data-bs-toggle="modal" data-bs-target="#myModal">
                            <i class="fa-solid fa-file-circle-plus"></i>
                        </button>
                          <!-- The Modal add folder -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <form action="{{ route('add.file') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Thêm tài liệu</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <input type="hidden" name="documentID" value="{{ $project->document->id }}">
                                            
                                            <div class="row mt-4">
                                                
                                                <label class="custom-file-input">
                                                    <input type="file" multiple onchange="updateFileList(this)" name="files[]"/>
                                                    <span id="file-count"></span>
                                                    <div class="file-info">
                                                      <ul class="file-list" id="file-list"></ul>
                                                    </div>
                                                </label>
                                            </div>

                                        </div>
                                    
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Xác nhận</button>
                                        </div>
                                    
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="" data-bs-toggle="modal" data-bs-target="#myModal">
                            <i class="fa-solid fa-folder-plus mt-1 mx-2"></i>
                        </button>
                          <!-- The Modal add folder -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <form action="{{ route('add.do') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Thêm thư mục</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <input type="hidden" name="documentID" value="{{ $project->document->id }}">
                                            <div class="mb-3 mt-3">
                                                <label for="do_son_name" class="form-label">Tên thư mục</label>
                                                <input type="text" class="form-control" id="do_son_name" placeholder="Nhập tên thư mục" name="do_son_name" required>
                                            </div>
                                            <div class="row mt-4">
                                                <div>Thêm tài liệu</div>
                                                <label class="custom-file-input">
                                                    <input type="file" multiple onchange="updateFileList(this)" name="files[]"/>
                                                    <span id="file-count"></span>
                                                    <div class="file-info">
                                                      <ul class="file-list" id="file-list"></ul>
                                                    </div>
                                                </label>
                                            </div>

                                        </div>
                                    
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Xác nhận</button>
                                        </div>
                                    
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div id="{{ $project->document->id }}" class="collapse">
                <div class="ms-5 ">
                    @foreach (App\Models\Doson::all() as $document)
                        @if($document->documentID == $project->document->id)
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fa-solid fa-folder mt-1 me-2"></i>
                                    <button type="button" id="toggle-icon-1" class="" data-bs-toggle="collapse" data-bs-target="#{{ $document->id  }}">{{ $document->do_son_name  }} <i class="fa-solid fa-angle-down"></i></button>
                                
                                </div>
                                <div class="d-flex">
                                    <div>
                                        <button type="button" class="" data-bs-toggle="modal" data-bs-target="#myModal">
                                            <i class="fa-solid fa-file-circle-plus"></i>
                                        </button>
                                          <!-- The Modal add folder -->
                                        <div class="modal" id="myModal">
                                            <div class="modal-dialog">
                                                <form action="{{ route('add.file') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Thêm tài liệu</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <input type="hidden" name="documentID" value="{{ $project->document->id }}">
                                                            
                                                            <div class="row mt-4">
                                                                
                                                                <label class="custom-file-input">
                                                                    <input type="file" multiple onchange="updateFileList(this)" name="files[]"/>
                                                                    <span id="file-count"></span>
                                                                    <div class="file-info">
                                                                      <ul class="file-list" id="file-list"></ul>
                                                                    </div>
                                                                </label>
                                                            </div>
                
                                                        </div>
                                                    
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Xác nhận</button>
                                                        </div>
                                                    
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="" data-bs-toggle="modal" data-bs-target="#myModal">
                                            <i class="fa-solid fa-folder-plus mt-1 mx-2"></i>
                                        </button>
                                          <!-- The Modal add folder -->
                                        <div class="modal" id="myModal">
                                            <div class="modal-dialog">
                                                <form action="{{ route('add.do') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Thêm thư mục</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <input type="hidden" name="documentID" value="{{ $project->document->id }}">
                                                            <div class="mb-3 mt-3">
                                                                <label for="do_son_name" class="form-label">Tên thư mục</label>
                                                                <input type="text" class="form-control" id="do_son_name" placeholder="Nhập tên thư mục" name="do_son_name" required>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <div>Thêm tài liệu</div>
                                                                <label class="custom-file-input">
                                                                    <input type="file" multiple onchange="updateFileList(this)" name="files[]"/>
                                                                    <span id="file-count"></span>
                                                                    <div class="file-info">
                                                                      <ul class="file-list" id="file-list"></ul>
                                                                    </div>
                                                                </label>
                                                            </div>
                
                                                        </div>
                                                    
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Xác nhận</button>
                                                        </div>
                                                    
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="{{ $document->id }}" class="collapse">
                                <div class="ms-5">
                                    @foreach (App\Models\FileSon::all() as $file)
                                        @if($file->document_sonID == $document->id)
                                            <div class=""> <i class="fa-solid fa-file"></i> {{ $file->file_son_name }}</div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="ms-5">
                    @foreach (App\Models\File::all() as $file)
                        @if($file->documentID == $project->document->id)
                            <div class=""><i class="fa-solid fa-file"></i> {{ $file->fileName }}</div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        // Lấy phần tử button hoặc biểu tượng
        const toggleButton = document.getElementById('toggle-icon');
        const icon = toggleButton.querySelector('i');
    
        // Lắng nghe sự kiện click
        toggleButton.addEventListener('click', function() {
            // Kiểm tra class hiện tại của icon và thay đổi class khi click
            if (icon.classList.contains('fa-angle-down')) {
                icon.classList.remove('fa-angle-down'); // Xóa class fa-angle-down
                icon.classList.add('fa-angle-right');   // Thêm class fa-angle-right
            } else {
                icon.classList.remove('fa-angle-right'); // Xóa class fa-angle-right
                icon.classList.add('fa-angle-down');     // Thêm class fa-angle-down
            }
        });
    </script>
    
</section>

