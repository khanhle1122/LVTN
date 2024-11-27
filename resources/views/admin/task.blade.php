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
              <select class="border border-0" style="background: #F7F7F7" id="projectSelect">
                  @foreach(App\Models\Project::all() as $item)
                      <option value="{{ route('view.task', $item->id) }}" 
                              @if($item->id == $project->id) selected @endif>
                          {{ $item->projectName }}
                      </option>
                  @endforeach
              </select>
          </li>
      </ol>
  </nav>
  
    <div class="row ">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-12 col-xl-12">
          <div class="card rounded">
              <div class="card-body"> 
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="tableTask-tab" data-bs-toggle="tab" href="#tableTask" role="tab" aria-controls="tableTask" aria-selected="true">Bảng công việc</a>
                  </li>
                 
                  <li class="nav-item">
                    <a class="nav-link" id="coat-tab" data-bs-toggle="tab" href="#coat" role="tab" aria-controls="coat" aria-selected="false">Chi phí dự án</a>
                  </li>
                  
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                  <div class="tab-pane fade show active" id="tableTask" role="tabpanel" aria-labelledby="tableTask-tab">
                    @include('admin.task.table-task')
                  </div>
                  
                  <div class="tab-pane fade" id="coat" role="tabpanel" aria-labelledby="coat-tab">
                    @include('admin.task.coat')
                  </div>
                </div>
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

<script>
  document.getElementById('projectSelect').addEventListener('change', function() {
      window.location.href = this.value;
  });
  </script>

<script>
  $(document).ready(function() {
  const currencySelect = $('#currencySelect');
  const budgetInputContainer = $('#budgetInputContainer');

  function updateBudgetInput() {
      const currency = currencySelect.val();
      const suffix = currency === 'vnd' ? '₫' : '$';
      const placeholder = currency === 'vnd' ? 'Nhập số tiền (VND)' : 'Nhập số tiền (USD)';

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
          groupSeparator: currency === 'vnd' ? '.' : ',',
          radixPoint: currency === 'vnd' ? ',' : '.',
          digits: currency === 'vnd' ? 0 : 2,
          autoUnmask: true,
          allowMinus: false, // Không cho phép số âm
          min: 0, // Giá trị tối thiểu là 0
          placeholder: "Nhập số tiền (VND)",
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

<script>

  $(document).ready(function() {
      // Áp dụng inputmask cho tất cả các trường có class `cost-mask` khi modal hiển thị
      $('.modal').on('shown.bs.modal', function() {
          Inputmask({
              alias: "numeric",
              groupSeparator: ".",
              radixPoint: ",",
              autoGroup: true,
              digits: 0,               // Không có phần thập phân
              digitsOptional: false,   // Không có phần thập phân
              prefix: "",
              suffix: " ₫",
              autoUnmask: true,
              removeMaskOnSubmit: true,
              allowMinus: false,
              min: 0,
              onBeforeMask: function(value, opts) {
                  return value < 0 ? '0' : value;
              }
          }).mask($('.budget-mask'));
      });
  });
  
  </script>

@endsection