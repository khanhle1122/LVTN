@extends('admin.admin_dashboard')
@section('admin')

@php
  $endDate = 0000-00-00 ; 

@endphp

<div class="page-content">
  <div class="row">
    <div class="col-12">
        <div class="card rounded">
            <div class="card-body"> 
              
              @include('admin.task.detail-project')


              <div id="print-content">
                <div>
                  <div>
                    <div class="d-flex justify-content-center">
                    <h2 class="mb-2 text-center">Báo cáo dự án: {{ $project->projectName }} </h2>
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
                                        <input type="hidden" name="totalCost" value="{{ $totalCost }}">
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
                  </div>
                  <div class="row mb-3">
                    <div class="">
                      <div class="d-flex">
                        <h3>Chi tiết dự án </h3>
                        
                      </div>
                      <div class="d-flex">
                        <div><span class="h6">Mã:</span> {{ $project->projectCode }} </div>
                        <div class="mx-3"> 
                          <span class="h6 ">Tên:</span> {{ $project->projectName }}
                        </div>
                        <div><span class="h6">Trạng thái: </span>
                          @if($project->status == 1)   
                                                  Đã hoàn thành

                                              @elseif($project->status ==2)
                                                  Tạm dừng
                                              @elseif($project->status ==0)
                                                  Đang tiến hành

                                              @elseif($project->status ==3)
                                                  Chậm tiến độ 
                                              @endif
                      </div>
                      </div>
                      <div class=""> </div>
                      
                      <div>
                          <span class="h6">Giám sát công trình:</span> 
                          @foreach(App\Models\WorkingProject::where('project_id',$project->id)->get() as $WorkingProject)
                              @if($WorkingProject->users) 
                                  @if($WorkingProject->is_work == 1)
                                  <div>{{ $WorkingProject->users->name }} ( đảm nhận từ {{ $WorkingProject->at_work }} đến {{ $WorkingProject->out_work }} )</div>
                                  @else()
                                  <div>{{ $WorkingProject->users->name }} ( đang đảm nhận )</div>
                                  @endif
                              
                              @endif
                          @endforeach
                          @php
                          $workingProjects = App\Models\WorkingProject::where('project_id', $project->id)->get();
                          @endphp
                          
                          @if($workingProjects->isEmpty())    
                          <div>{{ $project->user->name }}</div>

                          
                          @endif
                      </div>

                      
                      <div class="d-flex">
                        <div class=""><span class="h6">Loại công trình: </span>{{ $project->type }}</div>
                        <div class="mx-3"><span class="h6">Quy mô: </span>{{ $project->level }}</div>
                        <div><span class="h6">Ngân sách: </span>{{ $project->budget }}</div>
                      </div>
                      <div class="d-flex">
                        <div><span class="h6">Địa điểm thi công:</span> {{ $project->address }}</div>
                        <div class="mx-3"><span class="h6">Khởi công: </span>{{ $project->startDate }}</div>
                    
                        <div class="">
                            <span class="h6">Hoàn thành dự kiến: </span>{{ $project->endDate }}
                        </div>
                      </div>
                      <div class="d-flex">
                        <div><span class="h6">Đối tác:</span> {{ $project->contractors->name }} </div>
                        <div class="mx-3"><span class="h6">mã đối tác:</span> {{ $project->contractors->contactorCode }}</div>
                        
                        
                      </div>
                    </div>
                  </div>
                </div>
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
                    </tr>
                    </thead>
                    @php $counter = 1; @endphp
                    <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td><div class="">{{ $counter }}</div></td>
                            
                                @php $counter++; @endphp
                            <td><div class="">{{ $task->task_code }}</div></td>
                            <td><div class="">{{ $task->task_name }}</div></td>
                            <td><div class="">{{ $task->note }}</div></td>
                            <td><div class="">{{ $task->startDate }}</div></td>
                            <td><div class="">{{ $task->endDate }}</div></td>
                            
                            <td><div class="">{{ $task->users->name }} </div></td>
                                @php
                                  $endDate = $task->endDate ; 
                                  
                                @endphp
  
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
                        <td><div class="">{{ $counter }}</div></td>
                            
                                @php $counter++; @endphp
                        <td>{{ $coat->hangmuc }}</td>
                        <td>{{ $coat->estimated_cost }}</td>
                        <td>{{ $coat->description }}</td>
                        <td>{{ $coat->note }}</td>
                        
                      </tr>
                      @endforeach
                    
                    </tbody>
                  </table>
                </div>
                <div class="my-3 row">
                  <div class="">
                    <h3 class="mb-3">Chi tiết chi phí</h3>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Ngân sách dự kiến</th>
                          <th>Chi phí thực tế</th>
                          
                        </tr>
                      </thead>
                      @php $counter = 1; @endphp
                      <tbody>
                        <tr>
                          <td>{{ $project->budget }}</td>
                          <td id="totalCost">{{ $totalCost }}</td>
                        </tr>
                      
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="my-3 row">
                  <div class="">
                    <h3 class="mb-3">Tiến độ</h3>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Ngày hoàng thành dự kiến</th>
                          <th>Ngày hoàng thành thực tế</th>
                          
                        </tr>
                      </thead>
                      @php $counter = 1; @endphp
                      <tbody>
                        <tr>
                          <td>{{ $project->endDate }}</td>
                          <td>{{ $endDate }}</td>
                        </tr>
                      
                      </tbody>
                    </table>
                    <div class="d-flex mt-2">
                      <h4 >Kết luận:</h4>
                      <div class="mt-1 ms-2">
                        @if($project->endDate < $endDate ) 
                          <span class="text-danger h5">Chậm tiến độ</span>
                          @else
                          <span class="text-primary h5">Đúng tiến độ</span>
                          @endif
                      </div>
                    </div>
                  </div>
                </div>
                @if($project->report_status == 0 )
                <div class="my-3  row">
                  <div class="">
                    <h3>Đánh giá Chất lương</h3>
                    <div>
                      <form id="signupForm" action="{{ route('store.report',$project->id) }}" method="post" class="mt-3" >
                        @csrf
                        <div>
                          <div class="mb-3">
                            <label class="form-label">Đánh giá theo yêu cầu</label>
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
                          <label for="comment">Ghi chú:</label>
                          <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
                        </div>
                        <input type="hidden" name="totalCost" value="{{ $totalCost }}">                      
                        {{-- <input type="hidden" name="projectID" value="{{ $project->id }}"> --}}
                        <div>
                          <button type="submit" class="btn btn-primary mt-3" >Gửi báo cáo</button>
                        </div>
                        
                      </form>
                    </div>
                  </div>
                  
                </div>
                @else
                  <div class="row">
                    <div class="">
                      <h3 class="my-3">Chi tiết đánh giá</h3>
                      <div class="">
                        <div class="h5">Đánh giá mới nhất:</div>
                        
                        @foreach($reports as $report)
                        <div>Người viết báo cáo: <span>{{ $report->users->name }}</span></div>
                          <div><span class="h6">Chất lượng công trình:</span> @if($report->is_pass == 0) chưa đạt @else đạt @endif</div>
                          <div>
                            <div>Ghi chú:</div>
                            <div class="ms-1">{{ $report->comment }}</div>
                          </div>
                          
                        @endforeach
                      </div>
                    </div>
                  </div>
  
                @endif
              </div>
              @if($project->status_report == 1)
              <div class="no-print text-end pb-4">
                <button class="btn btn-dark " onclick="printContent()"><i data-feather="download" class="icon-sm"></i> <span class="ms-1"> In báo cáo</span></button>
              </div>
              @endif
            </div>
        </div>
    </div>
  </div>

</div>
<script>
  function printContent() {
    var content = document.getElementById('print-content').innerHTML;
    var originalContent = document.body.innerHTML;
    
    document.body.innerHTML = content;
    window.print();
    document.body.innerHTML = originalContent;
}

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
  <script>
    // Lấy giá trị totalCost từ thẻ HTML
    const totalCost = document.getElementById('totalCost').innerText;

    // Chuyển đổi totalCost thành số (nếu chưa phải là số)
    const number = parseFloat(totalCost);

    // Định dạng số theo kiểu 000.000
    const formattedCost = number.toLocaleString('vi-VN') + 'đ';

    // Cập nhật lại nội dung của thẻ <td>
    document.getElementById('totalCost').innerText = formattedCost;
</script>
@endsection