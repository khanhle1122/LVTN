@extends('admin.admin_dashboard')
@section('admin')


<div class="page-content">

  
  <div class="row ">
          
    @foreach($divisions as $item)
    @if($item)
    <div class="d-none mt-5 d-md-block col-md-3 col-xl-3  ">
      <div class="card"> 
        <div  class="card-body">
            <div class="mb-3 text-center ">
              <h5 class="col">{{ $item->divisionName }}</h5>
            </div>
            <div class="row mb-4">
              <div class="col-4">Mã nhân viên</div>
              <div class="col-8">Tên nhân viên</div>
            </div>
            @foreach(App\Models\User::where('divisionID',$item->id)->get() as $user)
              @if($user)
                <div class="row ">
                  <div class="col-4">{{ $user->usercode }}</div>
                  <div class="col-6 ">{{ $user->name  }}</div>
                  <div class="col-2">
                    <a href="{{ route('delete.member',$user->id) }}"><i data-feather="x" class="icon-sm text-danger"></i></a>
                  </div>
                </div>
              <hr>
              @else

              @endif()
            @endforeach
            <div class="add-member{{ $item->id }}" style="display:none">
              <form action="{{ route('add.member') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 row">
                  <select class="col form-select" name="userID" >
                    <option disabled selected>Chọn thành viên</option>
                    @foreach(App\Models\User::wherenull('divisionID')->where('role', '!=', 'admin')->get() as $user)
                      <option value="{{ $user->id }}">{{ $user->usercode }} - {{ $user->name }}</option>
                    @endforeach
                  </select>
                  <input type="hidden" name="divisionID" value="{{ $item->id }}">
                  <div class="col-3"><button class="btn btn-primary" type="submit">Thêm</button></div>
                </div>
                
              </form>
            </div>
            <div class="text-center " id="add-member{{ $item->id }}" style="cursor: pointer;"><i data-feather="plus"></i></div>
          </div>
      </div>
    </div>
    @endif
    @endforeach
    <div class="d-none mt-5 d-md-block col-md-3 col-xl-3  ">
      <div class="card"> 
        <div  class="card-body">
          <div id="add-division" class="text-center mt-4 mb-4" style="cursor: pointer;">
              <i data-feather="plus"></i>
          </div>
          <div class="add-division" style="display:none">
            <div class="row mb-3">
              <div class="col h5">Thêm Nhóm</div>
              <div class="col-2" id="close" style="cursor: pointer;"><i class="icon" data-feather="x"></i></div>
            </div>
            <form action="{{ route('add.division') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-sm">
                  <div class="mb-4">
                      <label>Tên nhóm:</label>
                      <input type="text" id="divisionName" class="form-control mt-2" placeholder="Nhập mã dự án" name="divisionName" required>
                  </div>
              </div>
              </div>
              <div class="d-flex justify-content-center" ><button class="btn btn-primary" type="submit">Thêm</button></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
 document.querySelectorAll(".text-center[id^='add-member']").forEach(function(button) {
    button.addEventListener("click", function() {
        // Hiện form thêm thành viên tương ứng
        const itemId = this.id.replace("add-member", ""); // Lấy ID của item
        document.querySelector(".add-member" + itemId).style.display = "block";

        // Ẩn nút "add-member" tương ứng
        this.style.display = "none";
    });
});

</script>
<script>
  document.getElementById("add-division").addEventListener("click", function() {
    // Hiện form thêm thành viên
    document.querySelector(".add-division").style.display = "block";
    // Ẩn nút "add-member"
    document.getElementById("add-division").style.display = "none";
});
</script>
<script>
  document.getElementById("close").addEventListener("click", function() {
    // Hiện form thêm thành viên
    document.querySelector(".add-division").style.display = "none";
    // Ẩn nút "add-member"
    document.getElementById("add-division").style.display = "block";
});
</script>
@endsection