@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

    <div class="row ">
<div class="col-md-12 col-xl-12  ">     
  <div class="card rounded">
      <div class="card-body"> 
        <h3 class="mb-3">Danh sách đối tác chờ tư vấn</h3>
        <div class="table-responsive">
          <table id="clientTable" class="table">
              <thead>
              <tr>
                  <th>Tên khách tư vấn</th>
                  <th>email</th>
                  <th>số điẹn thoại</th>
                  <th>Địa chỉ</th>
                  <th>Mô tả yêu cầu tư vấn</th>
                  <th>Trạng thái</th>
                  <th>Xác nhận</th>
                  <th></th>
              </tr>
              </thead>
              <tbody>  
                  @foreach($clients as $client)
                  @if($client->role=== 'client' )

                      <tr>
                          <td>{{ $client->name }}</td>
                          <td>{{ $client->email }}</td>
                          <td>{{ $client->phone }}</td>
                          <td>{{ $client->address }}</td>
                          <td>{{ $client->description }}</td>
                          <td>@if($client->status==0 ) Chờ duyệt @else Đã Tư vấn @endif</td>
                          <td>
                              @if($client->status == 0)
                              <a href="{{ route('check.status.client',$client->id) }}">
                                  Duyệt
                              </a>
                                @else
                                
                                  <i class=" ms-3 icon-sm text-success" data-feather="check"></i>
                             
                              @endif
                              

                          </td>   
                          <td>
                              <div class="d-flex">
                                  
                                  <a href="{{ route('delete.client.guest',$client->id) }}">
                                      <i data-feather="trash" class="icon-sm text-danger ms-3"></i>
                                  </a>
                              </div>
                          </td>
                      </tr>
                      @endif
                  @endforeach
              </tbody>
          </table>
        </div>


       
      </div>

  </div>
</div>
    </div>
</div>
<script>
  $(document).ready(function() {
      $('#clientTable').DataTable({
          columnDefs: [
                  { orderable: false, targets: 7 } // Chỉ định cột thứ 2 không cho phép sắp xếp
              ]
      });
      
  });
  </script>
@endsection