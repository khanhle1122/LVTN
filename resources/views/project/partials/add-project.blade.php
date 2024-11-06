
<section>
    <div>
        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
            <i class="fa-solid fa-plus"></i> Thêm Dự án  
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDocumentModalLabel">Thêm Dự án</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
    
                        <form id="addDocumentForm" action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-4">
                                <div class="col">
                                    <lablel>Mã dự án</lablel>
                                    <input type="text" class="form-control" placeholder="Nhập mã dự án" name="projectCode">
                                </div>
                                <div class="col">
                                    <label for="">Tên dự án</label>
                                    <input type="text" class="form-control" placeholder="Tên dự án" name="projectName">
                                </div>
                                <div class="col-2">
                                    <lablel>Ngày bắt đầu</lablel>
                                    <input type="date" class="form-control" placeholder="" name="startDate">
                                </div>
                                <div class="col-2">
                                    <label for="">Ngày kết thúc</label>
                                    <input type="date" class="form-control" placeholder="" name="endDate">
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="">Đối tác</label>
                                <input type="text" class="form-control" name="clientName">
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col">
                                    <lablel>Người giám sát</lablel>
                                    <select class="form-select" id="sel1" name="userID">
                                        @foreach(App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col ">
                                    <lablel>Quy mô dự án</lablel>
                                    <input type="text" class="form-control" placeholder="" name="level">
                                </div>
                                <div class="col">
                                    <lablel>ngân sách</lablel>
                                    <input type="text" id="numberInput" class="form-control" placeholder="" name="budget">
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
                            <div class="mt-4">
                                <label for="comment">Mô tả dự án:</label>
                                <textarea class="form-control" rows="5" id="comment" name="description"></textarea>
                            </div>
                            <div class="mt-4">
                                <button type="submit"  class="btn btn-primary">Thêm dự án</button>
                            </div>
                            
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div>
        
    </div>
    <script>
        
      </script>
    
</section>
