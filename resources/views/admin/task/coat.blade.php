<div>
    <h3 class="mt-2 mb-4">Chi phí dự án</h3>

    <div class="mt-2">
        <a type="button" class="btn btn-outline-primary" title="Thêm chi phí"  data-bs-toggle="modal" data-bs-target="#coatAdd">
            <i class="icon text-muted" data-feather="plus"></i> Thêm Chi phí
        </a>
        <div class="modal fade" id="coatAdd" tabindex="-1" aria-labelledby="coatAddLebel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="coatAddLebel">Thêm chi phí</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="addcoat" action="{{ route('add.coat') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 ">
                            <label class="form-check-label" for="hangmuc">Hạng mục</label>
                            <input type="text" class="form-control" name="hangmuc" id="hangmuc">
                        </div>
                        <div class="mb-3">
                            <lablel>Chi phí:</lablel>
                            <input name="estimated_cost"  autocomplete="estimated_cost" class="form-control mt-0" id="estimated_cost" data-inputmask="'alias': 'currency', 'suffix':'₫'"/>
                        </div>   
                        <div class="mb-3">
                            <lablel>Mô tả chi tiết:</lablel>
                            <textarea class="form-control" name="description" id="description"  rows="4"></textarea>
                        </div>    
                        <div class="mb-3">
                            <lablel>Ghi chú:</lablel>
                            <textarea class="form-control" name="note" id="note"  rows="4"></textarea>

                        </div>      
                        <input type="hidden" name="projectID" value="{{ $project->id }}">


                        <button type="submit" class="btn btn-primary float-end">Thêm</button>
                    </form>
                </div>
              </div>
            </div>
          </div>
    </div>
    @if(count($coats) >0 )
    <div class="table-responsive mt-3">
        <table id="dataTable" class="table">
          <thead>
            <tr>
              <th>Hạng mục</th>
              <th>Chi phí</th>
              <th>Mô tả chi tiết</th>
              <th>Ghi chú</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
           @foreach($coats as $coat)
            <tr>
              <td>{{ $coat->hangmuc }}</td>
              <td>{{ $coat->estimated_cost }}</td>
              <td>{{ $coat->description }}</td>
              <td>{{ $coat->note }}</td>
              <td>
                <div class="d-flex">
                    <div class="me-3">
                        <a href="#exampleModal{{ $coat->id }}" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $coat->id }}">                    
                            <i class="icon-sm text-warning" data-feather="edit-2"></i>
                        </a>
                        <div class="modal fade" id="exampleModal{{ $coat->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa chi phí</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-coat" action="{{ route('edit.coat') }}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="mb-3 ">
                                            <label class="form-check-label" for="hangmuc">Hạng mục</label>
                                            <input value="{{ $coat->hangmuc }}" type="text" class="form-control" name="hangmuc" id="hangmuc">
                                        </div>
                                        <div class="mb-3">
                                            <lablel>Chi phí cũ:</lablel>
                                            <input value="{{ $coat->estimated_cost }}"  class="form-control mt-0 " disabled type="text"/>
                                        </div> 
                                        <div class="mb-3">
                                            <lablel>Chi phí:</lablel>
                                            <input placeholder="nhập chi phí mới" name="estimated_cost"  autocomplete="estimated_cost" class="form-control mt-0 cost-mask " id="estimated_cost" data-inputmask="'alias': 'currency', 'suffix':'₫'"/>
                                        </div>   
                                        <div class="mb-3">
                                            <lablel>Mô tả chi tiết:</lablel>
                                            <input type="text" class="form-control" name="description" id="description" value="{{ $coat->description }}" rows="4"></input>
                                        </div>    
                                        <div class="mb-3">
                                            <lablel>Ghi chú:</lablel>
                                            <input type="text" class="form-control" name="note" id="note" value="{{ $coat->note }}"  rows="4"></input>
                
                                        </div>      
                                        <input type="hidden" name="id" value="{{ $coat->id }}">
                        
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                    </form>
                                </div>
                                
                              </div>
                            </div>
                          </div>


                    </div>
                    {{-- <div>
                        <a href="{{ route('delete.coat',$coat->id) }}">
                            <i class="icon-sm text-danger" data-feather="trash"></i>
                        </a>
                    </div> --}}
                </div>
              </td>
            </tr>
            @endforeach
            
          </tbody>
        </table>
    </div>
    @else
    <div class="text-center">Không có dữ liệu</div>
    @endif
    

</div>

<script>
    $(document).ready(function() {
    // Lấy các thành phần form
    const hangmucInput = $('#hangmuc');
    const estimatedCostInput = $('#estimated_cost');
    const descriptionInput = $('#description');
    const noteInput = $('#note');
    const submitButton = $('#addcoat button[type="submit"]');

    // Thêm sự kiện submit form
    $('#addcoat').on('submit', function(e) {
        e.preventDefault(); // Ngăn chặn form submit

        // Kiểm tra các trường
        let isValid = true;

        // Kiểm tra hạng mục
        if (hangmucInput.val().trim() === '') {
            isValid = false;
            hangmucInput.addClass('is-invalid');
            hangmucInput.next('.invalid-feedback').remove();
            hangmucInput.after('<div class="invalid-feedback">Vui lòng nhập hạng mục.</div>');
        } else {
            hangmucInput.removeClass('is-invalid');
            hangmucInput.next('.invalid-feedback').remove();
            hangmucInput.addClass('is-valid');
        }

        // Kiểm tra chi phí dự kiến
        if (estimatedCostInput.val().trim() === '') {
            isValid = false;
            estimatedCostInput.addClass('is-invalid');
            estimatedCostInput.next('.invalid-feedback').remove();
            estimatedCostInput.after('<div class="invalid-feedback">Vui lòng nhập chi phí dự kiến.</div>');
        } else {
            estimatedCostInput.removeClass('is-invalid');
            estimatedCostInput.next('.invalid-feedback').remove();
            estimatedCostInput.addClass('is-valid');
        }

        // Kiểm tra mô tả chi tiết
        if (descriptionInput.val().trim() === '') {
            isValid = false;
            descriptionInput.addClass('is-invalid');
            descriptionInput.next('.invalid-feedback').remove();
            descriptionInput.after('<div class="invalid-feedback">Vui lòng nhập mô tả chi tiết.</div>');
        } else {
            descriptionInput.removeClass('is-invalid');
            descriptionInput.next('.invalid-feedback').remove();
            descriptionInput.addClass('is-valid');
        }

        // Nếu form hợp lệ, submit form
        if (isValid) {
            this.submit();
        }
    });

    // Xử lý input mask cho trường chi phí dự kiến
    Inputmask({
        alias: "numeric",
        groupSeparator: ".",
        radixPoint: ",",
        autoGroup: true,
        digits: 0,
        digitsOptional: false,
        prefix: "",
        suffix: " ₫",
        placeholder: "0",
        autoUnmask: true,
        removeMaskOnSubmit: true,
        allowMinus: false,
        min: 0,
        onBeforeMask: function(value, opts) {
            return value < 0 ? '0' : value;
        }
    }).mask(estimatedCostInput);
});
  
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
            placeholder: "0",
            autoUnmask: true,
            removeMaskOnSubmit: true,
            allowMinus: false,
            min: 0,
            onBeforeMask: function(value, opts) {
                return value < 0 ? '0' : value;
            }
        }).mask($('.cost-mask'));
    });
});

  </script>

