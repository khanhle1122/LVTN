@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
  <div class="row">
    <div class="col-12">
        <div class="card rounded">
            <div class="card-body"> 
              <div class="d-flex">
                <h2 class="mb-2">Báo cáo dự án: {{ $project->projectName }}</h2>
                @if($project->report_status == 1)
                <div class="me-1 mt-2 ms-4">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#editProject{{ $project->id }}" title="Chỉnh sửa">
                      <i class="fa-regular fa-pen-to-square text-warning"></i>
                  </a>
                  @php 
                    $reportNew = $reports->first();
                  @endphp
                  <!-- Modal edit -->
                  <div class="modal fade" id="editProject{{ $project->id }}" tabindex="-1" aria-labelledby="editProjectLabel" aria-hidden="true">
                      <div class="modal-dialog ">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="editProjectLabel">Chỉnh sửa <span class="h5">{{ $project->projectName }}</span></h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form id="signupForm" action="{{ route('edit.report') }}" method="POST" class="mt-3" >
                                  @csrf
                                  <div>
                                    <div class="mb-3">
                                      <label class="form-label">Đánh giá </label>
                                      <div>
                                        <div class="form-check form-check-inline">
                                          <input type="radio" class="form-check-input" name="is_pass" id="gender1" value="1">
                                          <label class="form-check-label" for="gender1">
                                            Đạt
                                          </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input type="radio" class="form-check-input" name="is_pass" id="gender2" value="0">
                                          <label class="form-check-label" for="gender2">
                                            Chưa đạt
                                          </label>
                                        </div>
                                        
                                      </div>
                                    </div>
                                  </div>
                                  <div>
                                    <label for="comment">Bình luận:</label>
                                    <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
                                  </div>
                                  <input type="hidden" name="id" value="{{ $reportNew->id }}">
                                  <div>
                                    <button type="submit" class="btn btn-primary mt-3" >Gửi báo cáo</button>
                                  </div>
                                  
                                </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              @endif

              </div>
              @include('admin.task.detail-project')


              <div>
                <h3 class="mb-3">Danh sách công việc</h3>
                <table class="table table-bordered">
                  <thead>
                  <tr>
                      <th>STT</th>
                      <th>Mã </th>
                      <th>Tên công việc</th>
                      <th>Mô tả</th>
                      <th>Ngày bắt đầu</th>
                      <th>Ngày hoàn thành</th>
                      <th>phụ trách</th>
                      <th>Chi phí</th>
                  </tr>
                  </thead>
                  @php $counter = 1; @endphp
                  <tbody>
                  @foreach ($tasks as $task)
                      <tr>
                          <td><div class="mt-3">{{ $counter }}</div></td>
                          
                              @php $counter++; @endphp
                          <td><div class="mt-3">{{ $task->task_code }}</div></td>
                          <td><div class="mt-3">{{ $task->task_name }}</div></td>
                          <td><div class="mt-3">{{ $task->note }}</div></td>
                          <td><div class="mt-3">{{ $task->startDate }}</div></td>
                          <td><div class="mt-3">{{ $task->endDate }}</div></td>
                          
                          <td><div class="mt-3">{{ $task->users->name }} </div></td>
                          
                          <td><div class="mt-3">{{ $task->budget }}</div></td>
                         

                      </tr>
                      
                  @endforeach
                  
                  </tbody>
                </table>
              </div>
              <div class="my-3">
                <h3 class="mb-3">Danh sách chi phí</h3>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Hạng mục</th>
                      <th>Chi phí</th>
                      <th>Mô tả chi tiết</th>
                      <th>Ghi chú</th>
                    </tr>
                  </thead>
                  @php $counter = 1; @endphp
                  <tbody>
                    @foreach($coats as $coat)
                    <tr>
                      <td><div class="mt-3">{{ $counter }}</div></td>
                          
                              @php $counter++; @endphp
                      <td>{{ $coat->hangmuc }}</td>
                      <td>{{ $coat->estimated_cost }}</td>
                      <td>{{ $coat->description }}</td>
                      <td>{{ $coat->note }}</td>
                      
                    </tr>
                    @endforeach
                  
                  </tbody>
                </table>
                <h5 class="mt-3">Chi phí thực tế: {{ $totalCost }} đ</h5>
              </div>
              @if($project->report_status == 0 )
              <div class="my-3 row">
                <div class="col">
                  <h3>Đánh giá</h3>
                  <div>
                    <form id="signupForm" action="{{ route('store.report',$project->id) }}" method="post" class="mt-3" >
                      @csrf
                      <div>
                        <div class="mb-3">
                          <label class="form-label">Đánh giá</label>
                          <div>
                            <div class="form-check form-check-inline">
                              <input type="radio" class="form-check-input" name="is_pass" id="gender1" value="1">
                              <label class="form-check-label" for="gender1">
                                Đạt
                              </label>
                            </div>
                            
                            <div class="form-check form-check-inline">
                              <input type="radio" class="form-check-input" name="is_pass" id="gender2" value="0">
                              <label class="form-check-label" for="gender2">
                                Chưa đạt
                              </label>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                      <div>
                        <label for="comment">Bình luận:</label>
                        <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
                      </div>
                      <input type="hidden" name="totalCoat" value="{{ $totalCost }}">
                      {{-- <input type="hidden" name="projectID" value="{{ $project->id }}"> --}}
                      <div>
                        <button type="submit" class="btn btn-primary mt-3" >Gửi báo cáo</button>
                      </div>
                      
                    </form>
                  </div>
                </div>
                <div class="col">
                  <h3>File báo cáo chi tiết (pdf)</h3>
                  <div>
                    <form  action="{{ route('store.file.report') }}" class="mt-3" method="POST" enctype="multipart/form-data" id="importForm">
                      @csrf
                      <div class="mb-4">
                          <label for="fileInput">Chọn file:</label>
                          <input type="file" name="file" class="form-control" id="fileInput">
                          <!-- Invalid feedback sẽ được thêm vào đây bằng JS -->
                      </div>
                      
                      <input type="hidden" name="projectID" value="{{ $project->id }}">

                      <div>
                        <button type="submit" class="btn btn-primary mt-3" >Gửi báo cáo</button>
                      </div>
                  </form>
                    
                  </div>
                </div>
              </div>
              @else
                <div>
                  <h3 class="my-3">Chi tiết đánh giá</h3>
                  <div class="mb-3">
                    <div>Đánh giá mới nhat:</div>

                    @foreach($reports as $report)
                      <div><span class="h6">Chất lượng công trình:</span> @if($report->is_pass == 0) chưa đạt @else đạt @endif</div>
                      <div>
                        <div>Bình luận:</div>
                        <div class="ms-1">{{ $report->comment }}</div>
                      </div>
                      <hr>
                      <div>Đánh giá trước đó</div>


                    @endforeach
                  </div>
                </div>

              @endif
            </div>
        </div>
    </div>
  </div>

</div>
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
          if (fileExtension !== 'pdf') {
              showError(fileInput, 'File phải có định dạng .pdf');
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