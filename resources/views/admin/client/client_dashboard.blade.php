@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

    <div class="row ">
        <!-- left wrapper start -->
        
        <div class="col-md-12 col-xl-12  middle-wrapper">


            
            <div class="card rounded">
                <div class="card-body"> 
                  <h3 class="mb-3">Danh sách đối tác chờ tư vấn</h3>
                  <div class="table-responsive">
                    <table id="clientTable" class="table">
                        <thead>
                        <tr>
                            <th>Tên đối tác</th>
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
                                            <div>
                                                <a href="#exampleModal{{ $client->id }}"  data-bs-toggle="modal" data-bs-target="#exampleModal{{ $client->id }}">
                                                    <i class="icon-sm text-warning" data-feather="edit-2"></i>
                                                  </a>
                                                  <div class="modal fade" id="exampleModal{{ $client->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLabel">Nâng cấp Đối tác</h5>
                                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="mt-3" action="{{ route('edit.role.client') }}"  method="POST" id="signupForm">
                                                                @csrf
                                                                
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlSelect1" class="form-label">Trạng thái khách hàng</label>
                                                                    <select class="form-select" id="exampleFormControlSelect1" name="role">
                                                                        <option selected value="client">khách hàng tư vấn</option>
                                                                        <option value="contractor">nhà thâu thầu</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <input type="hidden" name="id" value="{{ $client->id }}">
                                                                <div class="text-center"><button class="btn btn-primary" type="submit">Thêm</button></div>
                                                            </form>
                                                        </div>
                                                        
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>
                                            
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
        <div class="col-md-3 col-xl-3 left-wrapper mt-4">
            <div class="card rounded">
                <div class="card-body"> 
                  <h3>Thêm gói thầu</h3>
                  <form class="mt-3" action="{{ route('add.client') }}"  method="POST" id="signupForm">
                      @csrf
                      <div class="mb-3">
                          <label for="name">Tên đối tác</label>
                          <input class="form-control" type="text" name="name" id="name">
                      </div>
                      <div class="mb-3">
                          <label for="email">email</label>
                          <input class="form-control" type="text" name="email" id="email">
                      </div>
                      <div class="mb-3">
                          <label for="">Số điện thoại</label>
                          <input  class="form-control" name="phone" id="phone" data-inputmask-alias="(+99) 9999-9999">                      </div>
                      <div class="mb-3">
                          <label for="">Địa chỉ</label>
                          <input class="form-control" type="text" name="address" id="address">
                      </div>
                      <div class="mb-3">
                          <label for="">Mô tả</label>
                          <textarea name="description" id="description" rows="4" class="form-control"></textarea>
                      </div>
                      <input type="hidden" name="role" value="contractor">
                      <div class="text-center"><button class="btn btn-primary" type="submit">Thêm</button></div>
                  </form>
  
  
  
                </div>
  
            </div>
        </div>
        <div class="col-md-9 col-xl-9 mt-4  middle-wrapper">
            <div class="card rounded">
                <div class="card-body"> 
                  <h3 class="mb-3">Danh sách Các gói thầu</h3>
                  <div class="table-responsive">
                    <table id="contractTable" class="table">
                        <thead>
                        <tr>
                            <th>Tên đối tác</th>
                            <th>email</th>
                            <th>số điẹn thoại</th>
                            <th>Địa chỉ</th>
                            <th>Yêu cầu tư vấn</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>  
                            @foreach($clients as $client)
                                @if($client->role=== 'contractor' )
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>{{ $client->address }}</td>
                                    <td>{{ $client->description }}</td>
                                    <td>@if($client->status==0) Đang đấu thầu @else Đã thầu @endif</td>
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <a href="#exampleModal{{ $client->id }}"  data-bs-toggle="modal" data-bs-target="#exampleModal{{ $client->id }}">
                                                    <i class="icon-sm text-warning" data-feather="edit-2"></i>
                                                  </a>
                                                  <div class="modal fade" id="exampleModal{{ $client->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa đối tác</h5>
                                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="mt-3" action="{{ route('edit.client') }}"  method="POST" id="signupForm">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="name">Tên đối tác</label>
                                                                    <input class="form-control" type="text" name="name" id="name" value="{{ $client->name }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="email">email</label>
                                                                    <input class="form-control" type="email" name="email" id="email" value="{{ $client->email }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Số điện thoại</label>
                                                                    <input class="form-control" type="text" name="phone" id="phone" value="{{ $client->phone }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Địa chỉ</label>
                                                                    <input class="form-control" type="text" name="address" id="address" value="{{ $client->address }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlSelect1" class="form-label">Trạng thái</label>
                                                                    <select class="form-select" id="exampleFormControlSelect1" name="status">
                                                                        <option @if($client->status == 0) selected @endif value="0">Đang đấu thầu</option>
                                                                        <option @if($client->status == 1) selected @endif value="1">Đã thầu</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Mô tả</label>
                                                                    <input name="description" id="description" value="{{ $client->description }}" class="form-control"></input>
                                                                </div>
                                                                <input type="hidden" name="id" value="{{ $client->id }}">
                                                                <div class="text-center"><button class="btn btn-primary" type="submit">Thêm</button></div>
                                                            </form>
                                                        </div>
                                                        
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>
                                            <div class="ms-3">            
                                                <a title="Thông tin" href="#{{ $client->id }}" data-bs-toggle="modal" data-bs-target="#modal-{{ $client->id }}">
                                                    <i class="icon-sm text-dark" data-feather="info"></i>
                                                </a>
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="modal-{{ $client->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Thông tin chi tiết</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <p><strong>Tên đối tác:</strong> {{ $client->name }}</p>
                                                                        <p><strong>Email:</strong> {{ $client->email }}</p>
                                                                        <p><strong>Số điện thoại:</strong> {{ $client->phone }}</p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p><strong>Địa chỉ:</strong> {{ $client->address }}</p>
                                                                        <p><strong>Trạng thái:</strong> 
                                                                            @if($client->status == 0)
                                                                                <span class="">Đang đấu thầu</span>
                                                                            @else
                                                                                <span class="">Đã Thầu</span>
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-3">
                                                                    <div class="col-12">
                                                                        <h6>Các dự án hợp các:</h6>

                                                                        <div class="row">
                                                                            <div class="col-3">Mã dự án</div>
                                                                            <div class="col-6">Tên dự án</div>
                                                                            <div class="col-3">Tiến độ</div>
                                                                        </div>
                                                                        @foreach($projects as $project)
                                                                            @if($project->clientID == $client->id) 
                                                                            <div class="row">
                                                                                <div class="col-3"><a href="{{ route('view.task',$project->id) }}">{{ $project->projectCode }}</a> </div>
                                                                                <div class="col-6"><a href="{{ route('view.task',$project->id) }}">{{ $project->projectName }}</a> </div>
                                                                                <div class="col-3">{{ $project->progress }} %</div>
                                                                            </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
        $('#clientTable').DataTable();
        $('#contractTable').DataTable();
    });
    </script>
@endsection