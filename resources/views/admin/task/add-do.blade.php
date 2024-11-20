<section>
    
    <div class="">
        <div class=" ">
            <h3 class="mt-2 mb-4">Thư mục dự án</h3>

            <div class="">
                @foreach($documents as $document)
                    @if($document->parentID == 0 )
                        <div class="row ms-2 ">
                            
                            <div class="col-4 ">
                                <i class="fa-solid fa-folder mt-1 "></i>

                                <a  id="toggle-icon_k" class="mx-2 text-muted toggle-icon_k" data-bs-toggle="collapse" data-bs-target="#demo">
                                    <span class="h5 ms-3">{{ $document->documentName }} </span>
                                    <i class="fa-solid fa-angle-down mx-3"></i>
                                </a>

                            </div>
                            @if($project->status != 3)
                            <div class="col-1 d-flex">
                                <div>
                                    
                                    <a type="button"  data-bs-toggle="modal" data-bs-target="#myModal{{ $document->id }}">
                                        <i class="icon text-muted" data-feather="file-plus"></i>
                                    </a>
                                    
                                    <!-- add file -->
                                    <div class="modal" id="myModal{{ $document->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                    
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Thêm file tài liệu</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                    
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="{{ route('add.file') }}" method="post" enctype="multipart/form-data" id="addfile1" class="file-upload-form">
                                                @csrf
                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <lablel>Thư mục chứa:</lablel>
                                                        <select class="form-select" id="documentID" name="documentID">
                                                            @foreach(App\Models\Document::where('projectID', $project->id)->get() as $doc)
                                                                
                                                                <option value="{{ $doc->id }}">{{ $doc->documentName }}</option>
                                                                    
                                                            @endforeach
                                                        </select>
                                                    </div>    
                                                </div>
                                                <div class="row mt-4 mb-5">
                                                    <div>Các tài liệu liên quan</div>
                                                    <label class="custom-file-input">
                                                        <input type="file" multiple onchange="updateFileList(this)" name="files[]"/>
                                                        <span id="file-count"></span>
                                                        <div class="file-info">
                                                            
                                                            <ul class="file-list" id="file-list"></ul>
                                                        </div>
                                                    </label>
                                                </div>
                                                





                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger" >Thêm</button>
                                                    </div>
                                            </form>

                                            
                                            


                                        </div>
                                    
                                        <!-- Modal footer -->
                                        
                                    
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div>
                                    <a type="button"  data-bs-toggle="modal" data-bs-target="#folder{{ $document->id }}">
                                        <i class="icon text-muted" data-feather="folder-plus"></i>
                                    </a>
                                    
                                    <!-- add folder -->
                                    <div class="modal" id="folder{{ $document->id }}">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                    
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                            <h4 class="modal-title">Thêm thư mục và tài liệu</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                    
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form action="{{ route('add.do') }}" method="post" enctype="multipart/form-data" class="form" id="addfile2" class="file-upload-form">
                                                    @csrf
                                                    <input type="hidden" name="projectID" value="{{ $project->id }}">
                                                    <div class="row mt-4">
                                                        <div class="col">
                                                            <lablel>Thư mục chứa:</lablel>
                                                            <select class="form-select" id="parentID" name="parentID">
                                                                @foreach(App\Models\Document::where('projectID', $project->id)->get() as $doc)
                                                                    
                                                                    <option value="{{ $doc->id }}">{{ $doc->documentName }}</option>
                                                                        
                                                                @endforeach
                                                            </select>
                                                        </div>    
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col">
                                                            <label for="documentName">Tên thư mục</label>
                                                            <input type="text" class="form-control" id="documentName" name="documentName" placeholder="Nhập tên thư mục" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4 mb-5">
                                                        <div>Các tài liệu liên quan</div>
                                                        <label class="custom-file-input">
                                                            <input type="file" multiple onchange="updateFileList(this)" name="files[]"/>
                                                            <span id="file-count"></span>
                                                            <div class="file-info">
                                                            
                                                            <ul class="file-list" id="file-list"></ul>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    





                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger" >Thêm</button>
                                                    </div>
                                                </form>

                                                
                                                


                                            </div>
                                    
                                            <!-- Modal footer -->
                                            
                                    
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-7"> </div>
                            


                            <div class="collapse col-12 mt-1" id="demo">
                                @foreach(App\Models\Document::all() as $doson)
                                    @if($doson->parentID == $document->id && $doson->status == 0)

                                        <div class="row ms-2 ">
                                            
                                            <div class="col-5 ">
                                                <i class="icon-sm " data-feather="folder"></i>

                                                <a  id="toggle-icon_k" class=" toggle-icon_k" data-bs-toggle="collapse" data-bs-target="#demo{{ $doson->id }}">
                                                    <span class="text-dark ms-2">{{ $doson->documentName }} </span>
                                                    <i class="fa-solid fa-angle-down mx-3 text-dark"></i>
                                                </a>

                                            </div>
                                           
                                            @if($project->status !=3)
                                            <div class="col-1 d-flex ms-4">

                                                
                                                <div class="col-6">
                                                    <a  class=" ms-1" type="button"data-bs-toggle="modal" data-bs-target="#deleteFolder">
                                                        <i class="icon-sm text-danger me-2" data-feather="trash"></i>
                                                    </a>
                                                    <!-- xoá -->
                                                    <div class="modal fade" id="deleteFolder" tabindex="-1" aria-labelledby="deleteFolderLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteFolderLabel">Xoá thư mục: {{ $doson->documentName }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="d-flex justify-content-between">
                                                                        <form action="{{ route('delete.folder') }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="id" value="{{ $doson->id }}">
                                                                            <button type="submit" class="btn btn-outline-danger"  title="xoá">
                                                                                xoá khỏi cơ sỡ dư liệu
                                                                            </button>
                
                
                                                                        </form>
                                                                    <div>
                                                                    <a  class="btn btn-outline-danger" href="{{ route('delete.folder.inter',$doson->id) }}">Xoá cục bộ</a></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                            <div class="collapse col-12 " id="demo{{ $doson->id }}">
                                                    @foreach(App\Models\File::all() as $file)
                                                        @if($file->documentID == $doson->id && $file->status == 0)
                                                        @php
                                                            // Lấy đuôi mở rộng của file
                                                            $extension = pathinfo($file->filePath, PATHINFO_EXTENSION);
                                                        @endphp
                                                            <div class="row">
                                                                <div class=" col-3">
                                                                    <i class="text-muted icon-sm ms-4"  data-feather="file"></i>
                                                                    {{-- <a href="{{ Storage::url( $file->filePath ) }}" target="_blank" class="mx-2">{{ $file->fileName }}</a> --}}
                                                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'pdf']))
                                                                    <!-- Hiển thị trực tiếp trên trình duyệt -->
                                                                        <a href="{{ Storage::url($file->filePath) }}" target="_blank" class="mx-2">{{ $file->fileName }}</a>
                                                                    @else
                                                                        <!-- Sử dụng Google Docs Viewer cho file không hỗ trợ -->
                                                                        <a href="https://docs.google.com/viewer?url={{ urlencode(Storage::url($file->filePath)) }}&embedded=true" target="_blank" class="mx-2">{{ $file->fileName }}</a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-2 ms-1">
                                                                    
                                                                </div>
                                                                @if($project->status !=3)
                                                                <div class="col-1 d-flex ">
                                                                    <div style="margin-left:2px;">
                                                                        <a href="{{ Storage::url($file->filePath) }} " download>
                                                                            <i class="icon-sm text-dark  me-2" data-feather="download"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a type="button"data-bs-toggle="modal" data-bs-target="#deleteFolder">
                                                                            <i class="icon-sm text-danger " data-feather="trash"></i>
                                                                        </a>
                                                                          <!-- xoáa -->
                                                                          <div class="modal fade" id="deleteFolder" tabindex="-1" aria-labelledby="deleteFolderLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                              <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                  <h5 class="modal-title" id="deleteFolderLabel">Xoá thư mục: {{ $doson->documentName }}</h5>
                                                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="d-flex justify-content-between">
                                                                                        <form action="{{ route('delete.file') }}" method="POST">
                                                                                            @csrf
                                                                                            @method('delete')
                                                                                            <button type="submit" class="btn btn-outline-danger" value="{{ $file->id }}" name="id" title="xoá">
                                                                                                xoá khỏi cơ sỡ dư liệu
                                                                                            </button>
                                
                                
                                                                                          </form>
                                                                                          <div><a  class="btn btn-outline-danger" href="{{ route('delete.file.inter',$file->id) }}">Xoá cục bộ</a></div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                              </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                @endif
                                                            </div>
                                                        @endif

                                                    @endforeach
                                               
                                            </div>

                                        </div>

                                    @endif
                                @endforeach
                                
                                    @foreach(App\Models\File::all() as $file)
                                        @if($file->documentID == $document->id)
                                        @php
                                            // Lấy đuôi mở rộng của file
                                            $extension = pathinfo($file->filePath, PATHINFO_EXTENSION);
                                        @endphp
                                        <div class="row ms-2 col-12">
                                            <div class=" col-4">
                                                <i class="text-muted icon-sm"  data-feather="file"></i>
                                                {{-- <a href="{{ Storage::url( $file->filePath ) }}"  class="mx-2">{{ $file->fileName }}</a> --}}
                                                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'pdf']))
                                                <!-- Hiển thị trực tiếp trên trình duyệt -->
                                                    <a href="{{ Storage::url($file->filePath) }}" target="_blank" class="mx-2">{{ $file->fileName }}</a>
                                                @else
                                                    <!-- Sử dụng Google Docs Viewer cho file không hỗ trợ -->
                                                    <a href="https://docs.google.com/viewer?url={{ urlencode(Storage::url($file->filePath)) }}&embedded=true" target="_blank" class="mx-2">{{ $file->fileName }}</a>
                                                @endif
                                            </div>
                                            <div class="col-1">
                                                
                                            </div>
                                            @if($project->status !=3)
                                            <div class="col-1 d-flex">
                                                <div>
                                                    <a href="{{ Storage::url($file->filePath) }} " download>
                                                        <i class="icon-sm text-dark mx-2" data-feather="download"></i>
                                                    </a>
                                                </div>
                                                <div>
                                                    <a type="button"data-bs-toggle="modal" data-bs-target="#deleteFolder">
                                                    <i class="icon-sm text-danger " data-feather="trash"></i>
                                                </a>
                                                  <!-- xoá -->
                                                  <div class="modal fade" id="deleteFolder" tabindex="-1" aria-labelledby="deleteFolderLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="deleteFolderLabel">Xoá thư mục: {{ $doson->documentName }}</h5>
                                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="d-flex justify-content-between">
                                                                <form action="{{ route('delete.file') }}" method="POST">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" class="btn btn-outline-danger" value="{{ $file->id }}" name="id" title="xoá">
                                                                        xoá khỏi cơ sỡ dư liệu
                                                                    </button>
        
        
                                                                  </form>
                                                                  <div><a  class="btn btn-outline-danger" href="{{ route('delete.file.inter',$file->id) }}">Xoá cục bộ</a></div>
                                                            </div>
                                                        </div>
                                                        
                                                      </div>
                                                    </div>
                                                  </div></div>
                                                
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                    @endforeach
                                
                              </div>

                        </div>

                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
    const formStates = {};

    // Theo dõi sự kiện khi chọn file cho tất cả input file
    $(document).on('change', 'input[type="file"]', function() {
        const formId = $(this).closest('form').attr('id');
        formStates[formId] = this.files.length > 0;
        updateFileList(this);
    });

    // Xử lý submit cho tất cả form có class 'file-upload-form'
    $(document).on('submit', '.file-upload-form', function(e) {
        const formId = $(this).attr('id');
        const fileInput = this.querySelector('input[type="file"]');
        const modal = $(this).closest('.modal');
        
        // Đảm bảo không gửi form khi điều kiện chưa đạt
        let validForm = true;
        
        // Kiểm tra nếu là form addfile2 thì validate thêm documentName
        if (formId === 'addfile2') {
            const documentNameInput = this.querySelector('input[id="documentName"]');
            const documentName = documentNameInput.value.trim();
            
            // Xóa thông báo lỗi cũ
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            
            // Kiểm tra documentName có được nhập hay không
            if (documentName === "") {
                documentNameInput.classList.add('is-invalid');
                const invalidFeedback = document.createElement('div');
                invalidFeedback.className = 'invalid-feedback';
                invalidFeedback.textContent = 'Vui lòng nhập tên thư mục';
                $(invalidFeedback).insertAfter(documentNameInput);
                validForm = false;
            }
        }
        
        // Kiểm tra xem đã chọn file chưa
        if (!formStates[formId] || fileInput.files.length === 0) {
            modal.find('.file-error').remove();
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger file-error mt-2';
            errorDiv.innerHTML = 'Vui lòng chọn ít nhất một file';
            fileInput.parentElement.appendChild(errorDiv);
            validForm = false;
        }
        
        // Nếu không thỏa mãn điều kiện, không submit form
        if (!validForm) {
            e.preventDefault();
            return false;
        }
        
        // Kiểm tra các điều kiện khác của file
        if (!updateFileList(fileInput)) {
            e.preventDefault();
            return false;
        }
        
        // Nếu mọi thứ ok, submit form
        this.submit();
    });

    // Reset trạng thái khi đóng modal
    $('.modal').on('hidden.bs.modal', function() {
        const formId = $(this).find('form').attr('id');
        formStates[formId] = false;
        
        const modal = $(this);
        modal.find('#file-count').text('0 files');
        modal.find('#file-list').empty();
        modal.find('.file-error').remove();
        modal.find('input[type="file"]').val('');
        
        // Reset trạng thái documentName input nếu có
        const documentNameInput = modal.find('input[name="documentName"]');
        if (documentNameInput.length) {
            documentNameInput.val('');
            documentNameInput.removeClass('is-invalid');
            documentNameInput.next('.invalid-feedback').remove();
        }
    });
});

function updateFileList(input) {
    // Tìm file-count và file-list trong cùng modal với input
    const modal = $(input).closest('.modal');
    const fileCountElement = modal.find('#file-count')[0];
    const fileListElement = modal.find('#file-list')[0];
    
    const fileCount = input.files.length;
    const maxFileSize = 60 * 1024 * 1024; // 60MB in bytes
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 
                         'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                         'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                         'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                         'text/plain'];

    // Xóa thông báo lỗi cũ trong modal hiện tại
    modal.find('.file-error').remove();
    fileListElement.innerHTML = '';
    
    let hasError = false;
    let errorMessages = [];

    // Kiểm tra có file được chọn không
    if(fileCount === 0) {
        errorMessages.push("Vui lòng chọn ít nhất một file");
        hasError = true;
    } else {
        for (let i = 0; i < fileCount; i++) {
            const file = input.files[i];
            
            // Kiểm tra định dạng file
            if (!allowedTypes.includes(file.type)) {
                errorMessages.push(`File "${file.name}" không đúng định dạng cho phép`);
                hasError = true;
                continue;
            }

            // Kiểm tra kích thước file
            if (file.size > maxFileSize) {
                errorMessages.push(`File "${file.name}" vượt quá 60MB`);
                hasError = true;
                continue;
            }

            // Thêm file hợp lệ vào danh sách
            const fileItem = document.createElement('li');
            fileItem.textContent = `${file.name} (${(file.size / (1024 * 1024)).toFixed(2)}MB)`;
            fileListElement.appendChild(fileItem);
        }
    }

    // Hiển thị số lượng file
    fileCountElement.textContent = fileCount > 0 ? `${fileCount} files` : '0 files';

    // Hiển thị lỗi nếu có
    if (hasError) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger file-error mt-2';
        errorDiv.innerHTML = errorMessages.join('<br>');
        fileListElement.parentElement.appendChild(errorDiv);
    }

    return !hasError;
}

        </script>



    <script>
        // Lấy tất cả các phần tử có class toggle-icon
        document.querySelectorAll('.toggle-icon_k').forEach(function(toggleButton) {
            const icon = toggleButton.querySelector('i.fa-angle-down, i.fa-angle-up');
            
            // Lắng nghe sự kiện click cho từng button
            toggleButton.addEventListener('click', function() {
                // Kiểm tra và thay đổi icon
                if (icon.classList.contains('fa-angle-down')) {
                    icon.classList.remove('fa-angle-down');
                    icon.classList.add('fa-angle-up');
                } else {
                    icon.classList.remove('fa-angle-up');
                    icon.classList.add('fa-angle-down');
                }
            });
        });
    </script>
</section>