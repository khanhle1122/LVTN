<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModal">
    <i class="fa-solid fa-trash "></i>
  </button>
  
  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Xoá nhân viên</h4>
          
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
            <div>Nếu bạn xoá nhân viên này các dự án do người này đãm nhận sẽ bỏ trống</div>
        </div>
        <form action="{{ route('delete-user') }}" method="post">
            @csrf
            @method('delete')
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" value="{{ $nhansu->id }}" name="id" data-bs-dismiss="modal">Xác nhận xoá</button>
            </div>
        </form>
        <!-- Modal footer -->
       
  
      </div>
    </div>
  </div>