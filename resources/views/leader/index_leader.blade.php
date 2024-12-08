@extends('leader.leader_dashboard')
@section('leader')

<div class="page-content">
    <div class="row">
        
        <div class="col-md ">

            <div class="card h-100">
                <div class="card body ">
                    <div class="m-3">
                        @foreach($projects as $project)
                        @foreach($divisions as $division)
                            @if($project->id == $division->tasks->projectID)
                                <div class="ps-3">@include('admin.task.detail-project')</div>
                                @break
                            @endif

                        @endforeach
                        @endforeach

                        <div class="mx-4 mb-4">
                            <h3 class="mt-4">Danh sách công việc</h3>
                            
                            <div class="table-responsive">
                                <table id="employee" class="table">
                                    <thead>
                                    <tr>
                                        <th>Mã dự án</th>
                                        <th>Tên công việc</th>
                                        <th>Mã công việc</th>
                                        <th>Trạng thái</th>
                                        <th>Thời gian bắt đầu</th>
                                        <th>Thời gian kết thúc</th>
                                        <th>Địa điểm</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($divisions as $division)
                                            @if($division->out_work == null)
                                                <tr>
                                                    <td>{{ $division->tasks->projects->projectCode }}</td>

                                                    <td>{{ $division->tasks->task_name }}</td>
                                                    <td>{{ $division->tasks->task_code }}</td>
                                                    <td>
                                                        @if($division->tasks->status == 0)
                                                        Đang thực hiện
                                                        @elseif($division->tasks->status == 1) 
                                                        Đã hoàn thành
                                                        @elseif($division->tasks->status == 2) 
                                                        Chậm tiến độ
                                                        @else 
                                                        Tạm dựng
                                                        @endif
                                                    </td>
                                                    <td>{{ $division->tasks->endDate }}</td>
                                                    <td>{{ $division->tasks->endDate }}</td>
                                                    <td>{{ $division->tasks->projects->address }}</td>
                                                </tr>

                                            @else

                                                <tr>
                                                    <td>{{ $division->tasks->task_name }}</td>
                                                    <td>{{ $division->tasks->task_code }}</td>
                                                    <td>
                                                        @if($division->is_work == 1)
                                                        Đã thay đổi nhóm
                                                    
                                                        @endif
                                                    </td>
                                                    <td>{{ $division->at_work }}</td>
                                                    <td>{{ $division->out_work }}</td>
                                                    <td>{{ $division->tasks->projects->address }}</td>

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
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#employee').DataTable({
            lengthMenu: [10, 25, 50, 100],
            
        });
    });
    </script>

    @endsection