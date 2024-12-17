@extends('supervisor.supervisor_dashboard')
@section('supervisor')

<div class="page-content">
    <div class="row">
        
        <div class="col-md ">

            <div class="card h-100">
                <div class="card body ">
                    <div class="m-3">
                        <h3 class="mb-4">Danh sách dự án</h3>
                        <div>
                            
                            <div class="table-responsive">
                                <table id="employeeTable" class="table">
                                    <thead>
                                    <tr>
                                        <th>Tên dự án</th>
                                        <th>Mã dự án</th>
                                        <th>Địa điểm</th>
                                        <th>Tiến độ</th>
                                        <th>Trạng thái</th>
                                        <th>Thời gian bắt đầu</th>
                                        <th>Thời gian kết thúc</th>
                                        <th>Ngân sách</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($projects as $project)
                                            
                                                    <tr>
                                            
                                                        <td><div class="mt-2 ">{{ $project->projectCode }}</div></td>
                                                        <td><div class="mt-2"><span class="">{{ $project->projectName  }}</span></div></td>
                                                        <td>
                                                            <div class="mt-2">{{ $project->address }}</div>
                                                        </td>
                                                        <td><div class="mt-2">{{ $project->progress }} %</div></td>
                                                        <td>
                                                            <div class="mt-2">
                                                                
                                                            @if($project->status == 1)   
                                                            <span class="badge bg-success-subtle text-success border border-success d-inline-flex align-items-center">
                                                                Đã hoàn thành
                                                            </span>
                                                            @elseif($project->status == 2)
                                                            <span class="badge bg-warning-subtle text-warning border border-warning d-inline-flex align-items-center">
                                                                Tạm dừng
                                                            </span>
                                                            @elseif($project->status == 0)
                                                            <span class="badge bg-primary-subtle text-primary border border-primary d-inline-flex align-items-center">
                                                                Đang tiến hành
                                                            </span>
                                                            @elseif($project->status == 3)
                                                            <span class="badge bg-danger-subtle text-danger border border-danger d-inline-flex align-items-center">
                                                                Chậm tiến độ
                                                            </span>
                                                            @endif
                        
                                                            </div>
                                                        </td>
                                                        <td><div class="mt-2">{{ $project->startDate }}</div></td>
                                                        <td><div class="mt-2">{{ $project->endDate }}</div></td>
                                                        <td><div class="mt-2">{{ $project->budget }}</div></td>
                                                        <td>
                                                            <div class="d-flex justify-content-between mt-2">
                                                                
                                                
                                                                
                                                                <div class="">
                                                                    <a  class="ms-2" href="{{ route('view.task.supervisor',$project->id) }}">
                                                                        <i class="fa-solid fa-eye text-primary"></i>
                                                                    </a>
                                                                    
                                                                </div>
                                                                
                                                            </div>
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
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#employeeTable').DataTable({
            lengthMenu: [10, 25, 50, 100],
            columnDefs: [
                    { orderable: false, targets: 8 } // Chỉ định cột thứ 2 không cho phép sắp xếp
                ],
            
        });
    });
</script>

    @endsection