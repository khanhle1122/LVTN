@extends('admin.admin_dashboard')
@section('admin')

<!-- Trong blade layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="page-content">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Dự án</a></li>
      <li class="breadcrumb-item"><a href="{{ route('project') }}">Danh sách dự án</a></li>
      <li class="breadcrumb-item">
        <select class="border border-0" style="background: #F7F7F7">
          @foreach(App\Models\Project::all() as $item)
            <option @if($item->id == $project->id) selected @endif> {{ $item->projectName }}</option>

          @endforeach
      </select></li>
    </ol>
  </nav>
  
    <div class="row ">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-6 col-xl-5">
          <div class="card rounded">
              <div class="card-body"> 
                <div class="d-flex justify-content-between">
                  <h3 class="h3">Chi tiết dự án</h3>
                  
                  <div>
                    <a class="btn-toggle mb-3" data-target="#projectDetail">
                    
                      <i class="fas fa-minus text-dark icon-sm">        </i>          
  
                      </a>
                  </div>
                </div>

                  
                  <div id="projectDetail" class="mt-4">
                      @include('admin.task.detail-project')
                  </div>
              </div>
          </div>
      </div>
      <div class="col-md-6 col-xl-7">
          <div class="card">
              <div class="card-body"> 
                <div class="d-flex justify-content-between">
                  <h3 class="h3 py-2 ps-2   ">Thư mục dự án </h3>
                  <a class="btn-toggle float-end mb-3" data-target="#taskAdd">
                    <i class="fas fa-minus icon-sm text-dark">     </i>            
                  </a>
                </div>
                  
                  <div id="taskAdd" class="mt-4">
                      @include('admin.task.add-do')
                  </div>
              </div>
          </div>
      </div>
      
                
             

          <div class="d-none mt-5 d-md-block col-md-16 col-xl-12  ">
              <div class=""> 

                <div  class="mt-4">
                  @include('admin.task.table-task')
                </div>
              </div>
          </div>
    </div>
</div>
<script>
  $(document).ready(function() {
    $('.btn-toggle').click(function() {
        var target = $(this).data('target');
        $(target).toggle(); // Thu nhỏ hoặc phóng to nội dung

        // Lấy icon bên trong nút và thay đổi class của nó
        var icon = $(this).find('i');
        if ($(target).is(':visible')) {
            icon.removeClass('fa-plus').addClass('fa-minus'); // Hiển thị dấu trừ khi phóng to
        } else {
            icon.removeClass('fa-minus').addClass('fa-plus'); // Hiển thị dấu cộng khi thu nhỏ
        }
    });
});


</script>
@endsection