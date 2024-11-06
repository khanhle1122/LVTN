<section>
    <p class="text-center h2">Danh sách dự án</p>
    <div class="mt-5">  
        
        <div class="row">
            <div class="row col">
                <span class="col-1">Mã dự án</span>
                <span class="col">Tên dự án</span>
                <span class="col-2">người phụ trách</span>          

                <span class="col-2">Đối tác</span>          
                <span class="col-1">Mức độ dự án</span>          
    
                {{-- <span class="col-2">Ngày bắt đầu</span> --}}
                <span class="col-2">Ngày hoàn thành</span>
                
                <span class="col-1">Tiến độ</span>
    
            </div>
            <div class="col-1">
                <span></span>
            </div>
        </div>
        @foreach($project as $project)
        <div class="row">
            <div class="col-11">
                
                    <a href="{{ route('view.task',$project->id) }}" class="row mt-4 p-1  cursor-pointer" >
                        <span class="col-1">{{ $project->projectCode }}</span>
                        <span class="col">{{ $project->projectName }}</span>
                        <span class="col-2">{{ $project->users->name }}</span>

                        <span class="col-2">{{ $project->clientName }}</span>
                        <span class="col-1">{{ $project->level }}</span>

                        {{-- <span class="col-2">{{ $project->startDate }}</span> --}}
                        <span class="col-2">{{ $project->endDate }}</span>
                        <span class="col-1">{{ $project->progress }}%</span>

                        
                    </a>            
                    
               
            </div>
            <span class="col-1 mt-1 ">
                <div class="d-flex justify-content-around mt-3">
                    <div class="me-2">
                        <form action="{{ route('delete-project') }}" method="POST" class="">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger" value="{{ $project->id }}" name="id" title="Chỉnh sửa">
                                <i class="fa-solid fa-trash "></i>
                            </button>
                        </form>    
                    </div>                
                    
                    <div class="">
                        
                        
                    </div>
                </div>
            </span>
        </div>
        @endforeach
    </div>



</section>