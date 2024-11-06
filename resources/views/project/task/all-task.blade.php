<section>
    <h3 class="h3 text-center">{{ $project->projectName	 }}</h3>
    <div>
        <div class="row mb-2">
            <a href="#" class="col-1 btn btn-outline-dark disabled">dạng bảng</a>
            <a href="{{ route('gantt-chart',$project->id) }}" class="col-2 btn btn-outline-dark mx-2">Biểu đồ grantt</a>
            <div class="col"></div>
        </div>
        <div>

            <button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                <i class="fa-solid fa-plus"></i> Tạo công việc
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addDocumentModalLabel">Thêm Dự án</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
        
                            <form id="addDocumentForm" action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="projectID" value="{{ $project->id }}">
                                <div class="row mt-4">
                                    
                                    <div class="col">
                                        <label for="">Tên công việc</label>
                                        <input type="text" class="form-control" placeholder="Tên công việc" name="task_name">
                                    </div>
                                    <div class="col-2">
                                        <label for="">Số thứ tự ưu tiên</label>
                                        <input type="number" min="1" class="form-control" placeholder="Thứ tự công việc" name="stt">
                                    </div>
                                    <div class="col-2">
                                        <lablel>Ngày bắt đầu</lablel>
                                        <input type="date" class="form-control" placeholder="" name="start">
                                    </div>
                                    <div class="col-2">
                                        <label for="">Ngày kết thúc</label>
                                        <input type="date" class="form-control" placeholder="" name="end">
                                    </div>
                                </div>
                                
                                
                                
                                <div class="row mt-4">
                                    <div class="col">
                                        <lablel>Người đảm nhận </lablel>
                                        <select class="form-select" id="sel1" name="userID">
                                                @foreach(App\Models\User::all() as $user)
                                                    @if($user->role =="1")
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endif
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <lablel>Công việc tiên quyết </lablel>
                                        <select class="form-select" id="sel1" name="parent_id">
                                            <option value="0">không có công việc tiên quyết</option>

                                                @foreach($tasks as $task)
                                                   
                                                    <option value="{{ $task->id }}">{{ $task->task_name }}</option>
                                                    
                                                @endforeach
                                        </select>
                                    </div>
                                    
                                    
                                </div>
                                
                                <div class="mt-4">
                                    <label for="comment">Ghi chú:</label>
                                    <textarea class="form-control" rows="5" id="comment" name="note"></textarea>
                                </div>
                                <div class="mt-4">
                                    <button type="submit"  class="btn btn-primary">Thêm dự án</button>
                                </div>
                                
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="">
        
            <div class="row bg-dark text-light py-3">
                <div class="col-1">STT</div>
                <div  class="col">tên công việc</div>
                <div class="col-1">Bắt đầu</div>
                <div class="col-2">Hoàn thành</div>
                <div class="col-1">CV tq</div>
                <div  class="col-2">Người thực hiện</div>
                <div  class="col-2"> Ghi chú</div>
            </div>
            <div>
                @if($tasks->count() > 0)
                    @foreach($tasks as $task)
                        @if($task->parent_id == 0)
                            <div class="row" data-bs-toggle="collapse" data-bs-target="#demo">
                                <div class="col-1">{{ $task->stt }}</div>
                                <div class="col">{{ $task->task_name	 }}</div>
                                <div class="col-1">10</div>
                                
                                <div class="col-2">10</div>
                                <div class="col-1">@if($task->stt ==1 )  @else {{ $task->stt -1 }} @endif</div>
                                <div class="col-2">{{ $task->users->name }}</div>
                                <div class="col-2">{{ $task->note }}</div>
                                
                            </div>
                            @foreach(App\Models\Task::all() as $sonTask)
                                @if($sonTask->parent_id == $task->id)
                                    <div class="row" >
                                        <div class="col-1">{{ $sonTask->stt }}</div>
                                        <div class="col" ><div class="ms-4">{{ $sonTask->task_name	 }}</div></div>
                                        <div class="col-1">10</div>
                                        <div class="col-2">10</div>
                                        <div class="col-1">{{ $task->stt }}</div>
                                        <div class="col-2 ">{{ $sonTask->users->name }}</div>
                                        <div class="col-2">{{ $sonTask->note }}</div>

                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @else
                    <div class="text-center">
                        Không có dữ liệu
                    </div>
                @endif
            </div>
                
              
             
            
          </div>




    </div>
</section>