@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="card rounded">
                <div class="card-body"> 
                    <h3 class="mb-3">Thông báo</h3>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                  <th>tiêu đề</th>
                                  <th>Nội dung</th>
                                  <th>trạng thái</th>
                                  <th>Thời gian</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($allNotifications as $notification)
                                <tr>
                                  <td>
                                    <div>{{ $notification->title }}</div>
                                  </td>
                                  <td>                                
                                    <div>{{ $notification->content }}</div>
                                  </td>
                                  <td>
                                    @if($notification->is_read == 0)
                                        <div>Chưa đọc</div>
                                    @else
                                        <div>Đã đọc</div>
                                        @endif
                                  </td>
                                  <td>{{ $notification->created_at->diffForHumans() }}</td>
                                  <td>
                                    @if($notification->is_read == 0)
                                    <a href="{{ route('check.notification', $notification->id) }}" title="đánh dấu đã đọc" class="">
                                      <i data-feather="check"></i>
                                    </a>
                                    @endif
                                  </td>
                                  
                                </tr>
                                @endforeach
                              </tbody>
                        </table>
                      </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection