<section>
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <div class="card_k">
        
        
        <div class="d-flex ">
            <div>
                <a href="{{ route('project.toggleStar',$project->id) }}" class="d-flex flex-row-reverse mt-2" > @if( $project->toggleStar == 1) <i class="fa-solid fa-star" style="color: #FFD43B;"></i> @else <i class="fa-regular fa-star" ></i>  @endif </a>
                
            </div>
            <div class="circle-k" style="background: conic-gradient(rgb(49, 164, 7) {{$project->progress}}%, #e0e0e0 0)">
                <span class="percentage_k">{{ $project->progress }}%</span>
            </div>
            
            <div class="ms-5">
                @if($project->status==1)
                <span class=" text-success">Đã hoàng thành</span>

            @endif
                <div class="">Mã: {{ $project->projectCode }}</div>
                <div class="">Tên: {{ $project->projectName }} </div>
                <div class="">Quy mô: {{ $project->level }}</div>
                <div class="">
                    <div>Khởi công: </div>
                    <div>{{ $project->startDate }}</div> 
                </div>
                <div class="">
                    <div>Hoàn thành dự kiến: </div>
                    <div>{{ $project->endDate }}</div> 
                </div>
                <div class="">Đối tác: {{ $project->clientName }}</div>
            </div>
            
        </div>
       
        <div>
            <div>Mô tả: </div>
            <div class="ms-2">{{ $project->description }}</div>
        </div>
    </div>
    
    
</section>

