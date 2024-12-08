<link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
<div class="mb-5">
    <div class="row">
        <h3 class="h3 col-6">Thông tin dự án @if($project->status==3) <span class="text-danger"> (chậm tiến độ) </span> @elseif($project->status == 1)  <span class="text-success"> (hoàn thành) </span>@elseif($project->status == 2)  <span class="text-warning"> (dự án tạm dừng)@elseif($project->status == 0)  <span class="text-primary"> (đang tiến hành) </span> </span> @endif</h3>
        <h3 class="col">Thư mục dự án</h3>

    </div>
    <div>
        @if($project->status != 2 &&  Auth::user()->role === "admin" || $project->status != 2 &&  Auth::user()->role === "root")

        <a href="{{ route('project.toggleStar',$project->id) }}" class=" mt-2" > @if( $project->toggleStar == 1) <i class="fa-solid fa-star" style="color: #FFD43B;"></i> @else <i class="fa-regular fa-star" ></i>  @endif </a>
        @endif
    </div>
    <div class="row" >
        <div class="col-6 row">
            
            <div class="circle-k col-3" style="background: @if($project->status == 3) conic-gradient(rgb(255, 0, 0) @else conic-gradient(rgb(49, 164, 7) @endif {{$project->progress}}%, #e0e0e0 0)">
                
                <span class="percentage_k">{{ $project->progress }}%</span>
            </div>
            <div class="col-1"></div>
            <div class="mx-2 col">
                

                <div class=""><span class="h6">Mã:</span> {{ $project->projectCode }}</div>
                <div class=""><span class="h6">Tên:</span> {{ $project->projectName }} </div>
                <div><span class="h6">Ngân sách: </span>{{ $project->budget }}</div>
                <div>
                    <span class="h6">Giám sát công trình:</span> 
                    @foreach(App\Models\WorkingProject::where('project_id',$project->id)->get() as $WorkingProject)
                        @if($WorkingProject->users) 
                            @if($WorkingProject->is_work == 1)
                            <div>{{ $WorkingProject->users->name }} ( đảm nhận từ {{ $WorkingProject->at_work }} đến {{ $WorkingProject->out_work }} )</div>
                            @else()
                            <div>{{ $WorkingProject->users->name }} ( đang đảm nhận )</div>
                            @endif
                        
                        @endif
                    @endforeach
                    @php
                    $workingProjects = App\Models\WorkingProject::where('project_id', $project->id)->get();
                    @endphp
                    
                    @if($workingProjects->isEmpty())    
                    <div>{{ $project->user->name }}</div>

                    
                    @endif
                </div>
                <div><span class="h6">Trạng thái: </span>
                    @if($project->status == 1)   
                                            Đã hoàn thành

                                        @elseif($project->status ==2)
                                            Tạm dừng
                                        @elseif($project->status ==0)
                                            Đang tiến hành

                                        @elseif($project->status ==3)
                                            Chậm tiến độ 
                                        @endif
                </div>
                <div class=""><span class="h6">Loại công trình: </span>{{ $project->type }}</div>
                <div class=""><span class="h6">Quy mô: </span>{{ $project->level }}</div>
                <div><span class="h6">Khởi công: </span>{{ $project->startDate }}</div>
               
                <div class="">
                    <span class="h6">Hoàn thành dự kiến: </span>{{ $project->endDate }}
                </div>
                <div class=""><span class="h6">Đối tác:</span> {{ $project->contractors->name }}</div>
                <div class=""><span class="h6">Địa điểm thi công:</span> {{ $project->address }}</div>
            </div>
        </div>
        <div class="col">
            @include('admin.task.add-do')
            <span class="h6 ms-5">Mô tả dự án: </span>
            <div class="ms-5"> {{ $project->description }}</div>
        </div>
    </div>
</div>