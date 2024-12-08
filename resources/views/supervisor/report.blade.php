@extends('supervisor.supervisor_dashboard')
@section('supervisor')
<style>
.perfect-scrollbar-example-x {
    position: relative;
    max-height: 850px;    
    overflow-x: auto; /* Thêm thanh cuộn ngang */
    white-space: nowrap; /* Ngăn các phần tử trong danh sách bị xuống dòng */
}

</style>
<style>
    .perfect-scrollbar-example {
  position: relative;
  max-height: 850px; 
overflow-y: auto; /* Thêm thanh cuộn dọc */

}
</style>
<div class="page-content">
  <div class="row">
    <div class="col-12">
      <div class="card rounded">
        <div class="card-body"> 
            @if($projects->isEmpty() && $projectReported->isEmpty())
            <div class="text-center h5">Chưa có dữ liệu cần báo cáo</div>
            @else
            <div class="perfect-scrollbar-example" style="height:850px">
              @if($projects->isEmpty())  
              @else
              <div >

                    <h3>Danh sách dự án cần báo cáo</h3>
                    <div class="mt-3 perfect-scrollbar-example-x">
                      @foreach($projects as $project)
                        <div class="col-2 ms-3 mt-3 p-1 pb-3" style="width:170px; display: inline-block;">
                            <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
                            <div class="card_k border shadow ">
                                <div class=" ">
                                    <a href="{{ route('report.detail.supervisor',$project->id) }}">
                                        <div class="circle-k me-3" style="background: conic-gradient(rgb(49, 164, 7) {{$project->progress}}%, #e0e0e0 0)">
                                            <span class="percentage_k">{{ $project->progress }}%</span>
                                        </div>
                                    </a>
                                    <div class="pt-3 ps-3 pb-3">
                                        <div class="ms-1"><a class="text-dark" href="{{ route('report.detail.supervisor',$project->id) }}">Mã: {{ $project->projectCode }}</a></div>
                                        <div class="ms-1"><a class="text-dark" href="{{ route('report.detail.supervisor',$project->id) }}">{{ $project->projectName }}</a></div>
                                        @if($project->status==1)
                                        <span class="ms-1 text-success">Đã hoàn thành</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                      @endforeach
                    </div>
                </div>
                @endif
                @if($projectReported->isEmpty())
                @else
                <div class="mt-5">
                    <h3>Danh sách đã báo cáo</h3>
                    <div class="mt-3 perfect-scrollbar-example-x">
                        @foreach($projectReported as $projected)
                        <div class="col-2 ms-3 mt-3 p-1 pb-3" style="width:170px; display: inline-block;">
                            <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
                            <div class="card_k border shadow ">
                                <div class=" ">
                                    <a href="{{ route('report.detail.supervisor',$projected->id) }}">
                                        <div class="circle-k me-3" style="background: conic-gradient(rgb(49, 164, 7) {{$projected->progress}}%, #e0e0e0 0)">
                                            <span class="percentage_k">{{ $projected->progress }}%</span>
                                        </div>
                                    </a>
                                    <div class="pt-3 ps-3 pb-3">
                                        <div class="ms-1"><a class="text-dark" href="{{ route('report.detail.supervisor',$projected->id) }}">Mã: {{ $projected->projectCode }}</a></div>
                                        <div class="ms-1"><a class="text-dark" href="{{ route('report.detail.supervisor',$projected->id) }}">{{ $projected->projectName }}</a></div>
                                        @if($projected->status==1)
                                        <span class="ms-1 text-success">Đã hoàng thành</span>
                                        @elseif($projected->status==0)
                                        <span class="ms-1 text-primary">Đang tiến hành</span>
                                        @elseif($projected->status==2)
                                        <span class="ms-1 text-danger">Đã tạm dừng</span>
                                        @else 
                                        <span class="ms-1 text-warning">Đã tạm dừng</span>
                                        
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                




            </div>
            @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection